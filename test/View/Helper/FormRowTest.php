<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Helper;

use Bootstrap\Form\Element\Text;
use Bootstrap\Form\View\Helper;
use BootstrapTest\Form\View\Helper\AbstractCommonTestCase;

final class FormRowTest extends AbstractCommonTestCase
{
    protected function setUp(): void
    {
        $this->helper = new Helper\FormRow();
        parent::setUp();
    }

    public function testFormRowIsDelegated(): void
    {
        self::assertInstanceOf(
            Helper\FormRow::class,
            $this->renderer->plugin('formrow'),
            'FormRow has not been properly delegated.'
        );
    }

    public function testFormRowCanRender(): void
    {
        $element = new Text('someText', []);
        $markup  = $this->helper->render($element);
        self::assertStringContainsString('<input', $markup);
    }
}
