<?php

declare(strict_types=1);

namespace Bootstrap\Form\Element;

use Bootstrap\Form\Element;

class Text extends Element
{
    /** @inheritDoc */
    protected $attributes                = [
        'type' => 'text',
    ];
    protected array $bootstrapAttributes = [
        'class' => 'form-group',
    ];
    protected ?string $wrapper           = '<div %s>%s</div>';
}
