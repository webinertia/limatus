<?php

declare(strict_types=1);

namespace Limatus\Form\Element\Delegator\Factory;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Limatus\Form\Element;
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
