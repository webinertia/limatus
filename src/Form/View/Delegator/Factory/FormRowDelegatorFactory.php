<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator\Factory;

use Bootstrap\Form\View\Delegator\FormRowDelegator;
use Bootstrap\Form\View\Helper\FormRow;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class FormRowDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): FormRowDelegator
    {
        $delegator = new FormRowDelegator(
            $container->get($name),
            $container->get(FormRow::class),
            $container->get('EventManager'),
            $container->get('config')['view_helper_config']['bootstrap']
        );
        $delegator->setView($container->get('ViewRenderer'));
        return $delegator;
    }
}
