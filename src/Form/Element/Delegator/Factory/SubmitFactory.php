<?php

declare(strict_types=1);

namespace Limatus\Form\Element\Delegator\Factory;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Limatus\Form\Element;
use Psr\Container\ContainerInterface;

class SubmitFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): Element\Submit {
        if ($options !== null) {
            return new Element\Submit(options: $options);
        }
        return new Element\Submit();
    }
}
