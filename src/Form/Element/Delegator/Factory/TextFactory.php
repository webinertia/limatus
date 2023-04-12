<?php

declare(strict_types=1);

namespace Bootstrap\Form\Element\Delegator\Factory;

use Bootstrap\Form\Element;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class TextFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): Element\Text {
        if ($options !== null) {
            return new Element\Text(options: $options);
        }
        return new Element\Text();
    }
}
