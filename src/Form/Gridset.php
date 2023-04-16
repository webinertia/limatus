<?php

declare(strict_types=1);

namespace Limatus\Form;

class Gridset extends Fieldset implements GridsetInterface
{
    /** @var array<TKEY, TVALUE> */
    protected $attributes = ['class' => 'form-row'];
}
