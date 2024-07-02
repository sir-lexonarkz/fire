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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[AsLiveComponent]
class SourceSearch extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private SourceRepository $sourceRepository)
    {
    }

    #[LiveListener('source:updated')]
    public function getSources(): mixed
    {
        // example method that returns an array of Sources
        return $this->sourceRepository->search($this->query);
    }

    #[LiveAction]
    public function refreshSource(EntityManagerInterface $entityManager, XMLImporter $xml, #[LiveArg] int $id): ?Response
    {

        $source = $entityManager->find(Source::class, $id);

        // get feed values
        $feed = $xml->xmlImporterFeed($source->getUrl());

        // get feed error or save feed values in article
        if (isset($feed['type']) && $feed['type'] === 'error') {
            $this->emit('alert:notice', [
                'message' => 'error: ' . $feed['message'],
                'type' => 'danger'
            ]);
            return null;
        } else {
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

            // show alert
            $this->addFlash(
                'notice',
                "$count post(s) added"
            );

            // return to homepage to refresh content
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
