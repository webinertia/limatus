<?php

declare(strict_types=1);

namespace Bootstrap\Form\Element\Delegator\Factory;

use Bootstrap\Form\Element;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class CheckboxFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): Element\Checkbox {
        if ($options !== null) {
            return new Element\Checkbox(options: $options);
        }
        return new Element\Checkbox();
    }
}
