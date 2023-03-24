<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Delegator;

use Bootstrap\Form\View\Helper;
use BootstrapTest\Form\View\Helper\AbstractCommonTestCase;
use Laminas\Form\View\Helper\FormRow;
use Laminas\Form\Element\Text;

use function get_class;

final class FormRowTest extends AbstractCommonTestCase
{
    protected function setup(): void
    {
        parent::setUp();
        $this->helper = $this->renderer->plugin('formrow');
        $this->helper->setView($this->renderer);
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
