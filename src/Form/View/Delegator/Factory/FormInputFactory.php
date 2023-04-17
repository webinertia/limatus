<?php

declare(strict_types=1);

namespace Limatus\Form\View\Delegator\Factory;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Limatus\Form\View\Helper;
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
