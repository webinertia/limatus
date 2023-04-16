<?php

declare(strict_types=1);

namespace Limatus\Form\Element;

use Limatus\Form\Element;

class Text extends Element
{
    /** @inheritDoc */
    protected $attributes = [
        'type' => 'text',
    ];
}
