<?php

declare(strict_types=1);

namespace Limatus;

class Module
{
    public function getConfig(): array
    {
        $provider = new ConfigProvider();
        return [
            'service_manager'    => $provider->getDependencyConfig(),
            'view_helpers'       => $provider->getViewHelperConfig(),
            'view_helper_config' => $provider->getHelperConfig(),
            'form_elements'      => $provider->getFormElementConfig(),
            'navigation_helpers' => $provider->getNavigationHelperConfig(),
        ];
    }
}
