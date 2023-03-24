<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Delegator;

use Bootstrap\Form\View\Helper;
use BootstrapTest\Form\View\Helper\AbstractCommonTestCase;
use Laminas\Form\View\Helper\FormRow;
use Laminas\Form\Element\Text;

final class FormRowTest extends AbstractCommonTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->helper->setView($this->renderer);
        $this->helper = $this->renderer->plugin('formrow');
    }

    public function testFormRowCanRender(): void
    {
        $element = new Text('someText', []);
        $markup  = $this->helper->render($element);
        self::assertStringContainsString('<input', $markup);
    }

    public function testFormRowIsDelegated(): void
    {
        self::assertInstanceOf(Helper\FormRow::class, $this->helper, 'FormRow has not been properly delegated.');
    }
}
