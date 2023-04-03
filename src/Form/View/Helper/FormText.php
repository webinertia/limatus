<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\View\Helper\FormHelperTrait;

final class FormText extends FormInput
{
    use FormHelperTrait;

    /**
     * Valid values for the input type = text
     *
     * @var array
     */
    protected $validTagAttributes = [
        'name'         => true,
        'autocomplete' => true,
        'autofocus'    => true,
        'dirname'      => true,
        'disabled'     => true,
        'form'         => true,
        'inputmode'    => true,
        'list'         => true,
        'maxlength'    => true,
        'minlength'    => true,
        'pattern'      => true,
        'placeholder'  => true,
        'readonly'     => true,
        'required'     => true,
        'size'         => true,
        'type'         => true,
        'value'        => true,
    ];
}
