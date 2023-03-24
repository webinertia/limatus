<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Helper;

use Bootstrap\ConfigProvider as BootstrapConfig;
use Laminas\Form\ConfigProvider;
use Laminas\Form\View\Helper\AbstractHelper;
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

    protected function setUp(): void
    {
        Doctype::unsetDoctypeRegistry();

        $this->renderer            = new PhpRenderer();
        $this->helperPluginManager = $this->renderer->getHelperPluginManager();
        $viewHelperConfig          = ArrayUtils::merge(
                                        (new configProvider())->getViewHelperConfig(),
                                        (new BootsrapConfig())->getViewHelperConfig()
                                    );
        $this->helperPluginManager->configure($viewHelperConfig);
        $this->renderer->setHelperPluginManager($this->helperPluginManager);

        //$this->helper->setView($this->renderer);
    }
}
