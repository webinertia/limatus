<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator\Factory;

use Bootstrap\Form\View\Helper\FormRow;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class FormRowFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): FormRow {
        return new FormRow();
    }
}