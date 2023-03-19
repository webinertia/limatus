<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;
use Bootstrap\Form\View\Helper\FormRowDelegator;

use function call_user_func;

class FormRowDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null): FormRowDelegator
    {
        //$formRow      = call_user_func($callback);
        $formRow      = $container->get($name);
        $eventManager = $container->get('EventManager');
        $eventManager->attach('render', function() {});
        $delegator    = new FormRowDelegator($formRow, $eventManager);
        return $delegator;
    }
}
