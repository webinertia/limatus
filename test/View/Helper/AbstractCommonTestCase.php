<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Helper;

use Bootstrap\ConfigProvider as BootstrapConfig;
use Laminas\Config\Config;
use Laminas\Form\ConfigProvider;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\View\Helper\Doctype;
use Laminas\View\Renderer\PhpRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Abstract base test case for all form view helpers
 */
abstract class AbstractCommonTestCase extends TestCase
{
    protected AbstractHelper $helper;
    protected PhpRenderer $renderer;

    protected function setUp(): void
    {
        Doctype::unsetDoctypeRegistry();
        $this->renderer      = new PhpRenderer();
        $helperPluginManager = $this->renderer->getHelperPluginManager();

        $viewHelperConfig    = new Config((new ConfigProvider())->getViewHelperConfig(), true);
        $bootstrapConfig     = new Config((new BootstrapConfig())->getViewHelperConfig(), true);
        $merged              = $viewHelperConfig->merge($bootstrapConfig);

        $helperPluginManager->configure($merged->toArray());
        $this->renderer->setHelperPluginManager($helperPluginManager);

        $this->helper->setView($this->renderer);
    }
}
