<?php

declare(strict_types=1);

namespace Limatus\Form\Element;

use Limatus\Form\Element;

class Button extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'button',
    ];
}
