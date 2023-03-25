<?php

declare(strict_types=1);

namespace Bootstrap\Form\Element;

use Laminas\Form\Element\Text;

class Test extends Text
{
    protected $attributes = [
        'type' => 'test'
    ];
}
