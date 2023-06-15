<?php

declare(strict_types=1);

namespace Limatus\Form\Element;

use Laminas\Form\ElementPrepareAwareInterface;
use Laminas\Form\FormInterface;
use Limatus\Form\Element;

final class Password extends Element implements ElementPrepareAwareInterface
{
    /** @inheritDoc */
    protected $attributes = [
        'type' => 'password',
    ];

    public function prepareElement(FormInterface $form): void
    {
        $this->setValue('');
    }
}
