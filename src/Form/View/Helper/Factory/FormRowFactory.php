<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\Form\View\Helper\FormRow;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

final class FormRowFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): FormRow
    {
        $helper = new $requestedName($container->get('EventManager'), $container->get('config'));
        //$helper->setView($container->get('ViewRenderer'));
        return $helper;
    }
}
