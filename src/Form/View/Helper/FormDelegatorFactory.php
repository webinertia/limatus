<?php

declare(strict_types=1);

namespace Limatus\Form\View\Helper;

use Laminas\EventManager\EventManagerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class FormDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): FormDelegator {
        $em        = $container->get(EventManagerInterface::class);
        $delegator = new FormDelegator();
        $delegator->setEventManager($em);
        return $delegator;
    }
}
