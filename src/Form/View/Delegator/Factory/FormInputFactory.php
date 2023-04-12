<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator\Factory;

use Bootstrap\Form\View\Helper;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class FormInputFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): Helper\FormInput {
        return new Helper\FormInput();
    }
}
