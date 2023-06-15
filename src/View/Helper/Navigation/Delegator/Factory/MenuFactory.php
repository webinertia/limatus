<?php

declare(strict_types=1);

namespace Limatus\View\Helper\Navigation\Delegator\Factory;

use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Limatus\View\Helper\Navigation\Menu;
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
        /** @phpstan-ignore-next-line */
        return (new Menu())->setUseAcl($container->has(AclInterface::class) || $container->has(Acl::class));
    }
}
