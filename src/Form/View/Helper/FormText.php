<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

final class FormText extends FormInput
{
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
    public function __invoke(?ElementInterface $element = null, ?string $mode = self::DEFAULT_MODE): string
    {
        return $this->render($element, $mode);
    }
}
