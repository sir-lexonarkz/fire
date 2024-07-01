<?php

namespace App\Twig\Components;

use App\Entity\Article;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Repository\SourceRepository;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use App\Service\XMLImporter;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use App\Entity\Source;


#[AsLiveComponent]
class SourceSearch
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private SourceRepository $sourceRepository)
    {
    }

    #[LiveListener('source:updated')]
    public function getSources(): array
    {
        // example method that returns an array of Sources
        return $this->sourceRepository->search($this->query);
    }

    #[LiveAction]
    public function refreshSource(EntityManagerInterface $entityManager, XMLImporter $xml, #[LiveArg] int $id)
    {
        $source = $entityManager->find(Source::class, $id);
        $feed = $xml->XMLImporterFeed($source->getUrl());
        if (!$feed) {
            $this->emit('source:notice', [
                'message' => 'error',
                'type' => 'danger'
            ]);
        } else {;
            $count = 0;
            foreach ($feed->item as $item) {
                $article = new Article();
                $article->setName($item->title);
                $article->setSource($source);
                $article->setContent($item->description);
                $entityManager->persist($article);
                $entityManager->flush();
                $count++;
            }
            $this->emit('source:notice', [
                'message' => "refreshed $count post(s)"
            ]);
        }
    }
}
