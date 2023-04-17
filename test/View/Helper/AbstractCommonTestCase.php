<?php

declare(strict_types=1);

namespace LimatusTest\Form\View\Helper;

use Limatus\ConfigProvider as LimatusConfig;
use Laminas\Config\Config;
use Laminas\Form\ConfigProvider;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\View\Helper\Doctype;
use Laminas\View\Renderer\PhpRenderer;
use PHPUnit\Framework\TestCase;

use function assert;

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
        /** @var array $laminasConfig */
        $laminasConfig       = (new ConfigProvider())->getViewHelperConfig();
        $viewHelperConfig    = new Config($laminasConfig, true);
        $bootstrapConfig     = new Config((new LimatusConfig())->getViewHelperConfig(), true);
        $merged              = $viewHelperConfig->merge($bootstrapConfig);

        $helperPluginManager->configure($merged->toArray());
        $this->renderer->setHelperPluginManager($helperPluginManager);

        $this->helper->setView($this->renderer);
    }
}
