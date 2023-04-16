<?php

declare(strict_types=1);

namespace Bootstrap\View\Helper\Navigation\Delegator\Factory;

use Bootstrap\View\Helper\Navigation\Menu;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class MenuFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): Menu {
        return new Menu();
    }
}
