<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveArg;

#[AsLiveComponent]
class Alert
{
    use DefaultActionTrait;

    public string $type = '';
    public string $message = '';

    public function __construct()
    {
    }

    #[LiveListener('alert:notice')]
    public function onFooBar(
        #[LiveArg('message')] string $message,
        #[LiveArg('type')] string $type = 'success'
    )
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function getIcon(): string
    {
        return match ($this->type) {
            'success' => 'circle-check',
            'danger' => 'alert-circle',
        };
    }
}
