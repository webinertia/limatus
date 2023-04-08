<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\Fieldset;

class Gridset extends Fieldset implements GridSetInterface
{
    protected $attributes = ['class' => 'form-row'];
}
