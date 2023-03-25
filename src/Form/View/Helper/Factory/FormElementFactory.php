<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\Form\View\Helper\FormElement;
use Psr\Container\ContainerInterface;

class FormElementFactory
{
    public function __invoke(ContainerInterface $container): FormElement
    {
        $helper = new FormElement();
        return $helper;
    }
}
