<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Form\View\Helper\Bootstrapper;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class BootstrapperFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Bootstrapper
    {
        $helperConfig = [];
        $config       = $container->get('config');
        if (isset($config['view_helper_config'][$requestedName::VHC_KEY])) {
            $helperConfig = $config['view_helper_config'][$requestedName::VHC_KEY];
        }
        return new $requestedName($helperConfig);
    }
}
