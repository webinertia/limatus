<?php

declare(strict_types=1);

namespace Bootstrap\Form\Element\Delegator\Factory;

use Bootstrap\Form\Element;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class ElementDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): Element {
        return new Element();
    }
}
