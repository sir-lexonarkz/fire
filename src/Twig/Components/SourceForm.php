<?php

namespace App\Twig\Components;

use App\Entity\Source;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;


#[AsLiveComponent]
class SourceForm
{
    use ComponentToolsTrait;
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $name = '';

    #[LiveProp(writable: true)]
    #[NotBlank]
    #[Url]
    public string $url = '';

    #[LiveAction]
    public function saveSource(EntityManagerInterface $entityManager): void
    {
        $this->validate();

        $source = new Source();
        $source->setName($this->name);
        $source->setUrl($this->url);
        $entityManager->persist($source);
        $entityManager->flush();

        // refresh search list
        $this->emit('source:updated');

        // show alert
        $this->emit('alert:notice', [
            'message' => 'updated'
        ]);

        // reset the fields in case the modal is opened again
        $this->name = '';
        $this->url = '';
        $this->resetValidation();
    }
}
