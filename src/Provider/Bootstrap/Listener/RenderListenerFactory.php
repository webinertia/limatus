<?php

declare(strict_types=1);

namespace Limatus\Provider\Bootstrap\Listener;

use Laminas\View\Helper\HtmlAttributes;
use Laminas\View\HelperPluginManager;
use Limatus\ConfigProvider;
use Psr\Container\ContainerInterface;

final class RenderListenerFactory
{
    public function __invoke(ContainerInterface $container): RenderListener
    {
        $attribHelper = ($container->get(HelperPluginManager::class))->get(HtmlAttributes::class);
        return new RenderListener(
            $attribHelper(),
            $container->get('config')['view_helper_config'][ConfigProvider::class]
        );
    }
}
