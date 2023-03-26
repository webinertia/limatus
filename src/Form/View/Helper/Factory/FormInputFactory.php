<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper\Factory;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View\Helper\FormInput;
use Psr\Container\ContainerInterface;

use function is_array;

class FormInputFactory
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container): FormInput
    {
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
