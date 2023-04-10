<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\Fieldset;

class Gridset extends Fieldset implements GridsetInterface
{
    /** @var array<TKEY, TVALUE> */
    protected $attributes = ['class' => 'form-row'];
}
