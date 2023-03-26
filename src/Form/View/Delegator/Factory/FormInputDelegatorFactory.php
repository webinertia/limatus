<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Delegator\Factory;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View\Helper\FormInput;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class FormInputDelegatorFactory implements DelegatorFactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        ?array $options = null
    ): FormInput {
        $helper = new FormInput();
        if (! $container->has('config')) {
            return $helper;
        }
        $config = $container->get('config');
        if (isset($config['view_helper_config'][BootstrapInterface::VIEW_HELPER_CONFIG_KEY])) {
            if (is_array($config['view_helper_config'][BootstrapInterface::VIEW_HELPER_CONFIG_KEY])) {
                $helper->setConfig(
                    $config['view_helper_config'][BootstrapInterface::VIEW_HELPER_CONFIG_KEY]
                );
            }
        }
        return $helper;
    }
}
