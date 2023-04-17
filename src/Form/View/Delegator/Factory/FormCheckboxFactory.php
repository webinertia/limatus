<?php

declare(strict_types=1);

namespace Limatus\Form\View\Delegator\Factory;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Limatus\Form\View\Helper\FormCheckbox;
use Psr\Container\ContainerInterface;

class FormCheckboxFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): FormCheckbox {
        return new FormCheckbox();
    }
}
