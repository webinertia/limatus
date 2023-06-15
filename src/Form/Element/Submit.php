<?php

declare(strict_types=1);

namespace Limatus\Form\Element;

use Limatus\Form\Element;

class Submit extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'submit',
    ];
}
