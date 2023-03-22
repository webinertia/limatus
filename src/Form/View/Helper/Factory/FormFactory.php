<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\Form\View\Helper\Form;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class FormFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Form
    {
        return new $requestedName($container->get('EventManager'), $container->get('config'));
    }
}
