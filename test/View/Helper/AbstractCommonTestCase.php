<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Helper;

use Bootstrap\ConfigProvider;
use Laminas\Form\View\Helper\AbstractHelper;
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

    protected function setUp(): void
    {
        Doctype::unsetDoctypeRegistry();

        $this->renderer            = new PhpRenderer();
        $this->helperPluginManager = $this->renderer->getHelperPluginManager();
        $viewHelperConfig          = (new ConfigProvider())->getViewHelperConfig();
        $this->helperPluginManager->configure($viewHelperConfig);
        $this->renderer->setHelperPluginManager($this->helperPluginManager);

        //$this->helper->setView($this->renderer);
    }
}
