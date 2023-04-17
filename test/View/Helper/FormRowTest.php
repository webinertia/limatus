<?php

declare(strict_types=1);

namespace LimatusTest\Form\View\Helper;

use Limatus\Form\Element\Text;
use Limatus\Form\View\Helper;
use LimatusTest\Form\View\Helper\AbstractCommonTestCase;

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
