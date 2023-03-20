<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Delegator;

use BootstrapTest\Form\View\Helper\AbstractCommonTestCase;
use Bootstrap\Form\View\Helper\FormRow;
use Laminas\Form\Element\Text;

final class FormRowDelegatorTest extends AbstractCommonTestCase
{
    protected function setup(): void
    {
        $this->helper = new FormRow();
        parent::setUp();
    }
    public function testFormRowCanRender(): void
    {
        $element = new Text('someText', []);
        $markup  = $this->helper->render($element);
        self::assertStringContainsString('<input', $markup);
    }
}
