<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use UnhandledMatchError;

#[AsLiveComponent]
class Alert
{
    use DefaultActionTrait;

    public string $type = '';
    public string $message = '';

    #[LiveListener('alert:notice')]
    public function onFooBar(
        #[LiveArg('message')] string $message,
        #[LiveArg('type')] string $type = 'success'
    ): void {
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * The getIcon function returns an icon based on the type, defaulting to 'circle-check'.
     * @return string The `getIcon()` function returns a string value based on the type property of the
     * object. If the type is 'success', it returns 'circle-check'. If the type is 'danger', it returns
     * 'alert-circle'. Otherwise, it returns 'circle-check' by default.
     */
    public function getIcon(): string
    {
        return match ($this->type) {
            'success' => 'circle-check',
            'danger' => 'alert-circle',
            default => 'circle-check'
        };
    }
}
