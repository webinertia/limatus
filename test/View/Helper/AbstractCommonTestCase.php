<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Helper;

use Bootstrap\ConfigProvider as BootstrapConfig;
use Laminas\Config\Config;
use Laminas\Form\ConfigProvider;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Stdlib\ArrayUtils;
use Laminas\View\HelperPluginManager;
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
    protected HelperPluginManager $helperPluginManager;
    protected ServiceManager $sm;

    protected function setUp(): void
    {
        Doctype::unsetDoctypeRegistry();
        $this->sm            = new ServiceManager();
        $this->renderer      = new PhpRenderer();
        $helperPluginManager = $this->renderer->getHelperPluginManager();
        $viewHelperConfig    = new Config((new ConfigProvider())->getViewHelperConfig(), true);
        $bootstrapConfig     = new Config((new BootstrapConfig())->getViewHelperConfig(), true);
        $merged              = $viewHelperConfig->merge($bootstrapConfig);
        $helperPluginManager->configure($merged->toArray());
        $this->sm->setService('ViewHelperManager', $helperPluginManager);
        $this->renderer->setHelperPluginManager($helperPluginManager);

        $this->helper->setView($this->renderer);
    }
}
