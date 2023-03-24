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
        $this->helper = new Helper\FormRow();
        parent::setUp();
    }

    public function testFormRowCanRender(): void
    {
        $element = new Text('someText', []);
        $markup  = $this->helper->render($element);
        self::assertStringContainsString('<input', $markup);
    }

    public function testFormRowIsDelegated(): void
    {
        self::assertInstanceOf(Helper\FormRow::class, $this->renderer->plugin('formrow'), 'FormRow has not been properly delegated.');
    }
}
