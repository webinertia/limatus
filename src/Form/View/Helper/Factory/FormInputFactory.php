<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper\Factory;

use Limatus\Form\View\Helper;
use Laminas\Form\View\Helper\FormInput;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class FormInputFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Helper\FormInput
    {
        // prefer the instance from the manager
        if ($container->has('ViewHelperManager') && $container->get('ViewHelperManager')->has(FormInput::class)) {
            return new $requestedName($container->get('ViewHelperManager')->get(FormInput::class));
        }
        return new $requestedName(new FormInput());
    }
}
