<?php

declare(strict_types=1);

namespace Limatus\Form\View\Delegator\Factory;

use Limatus\Form\View\Helper\FormCheckbox;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
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
