<?php

declare(strict_types=1);

namespace BootstrapTest\Form\View\Delegator;

use Bootstrap\Form\View\Helper;
use BootstrapTest\Form\View\Helper\AbstractCommonTestCase;


class FormInputTest extends AbstractCommonTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->helper = $this->renderer->plugin('forminput');
        $this->helper->setView($this->renderer);
    }

    public function testFormInputIsDelegated(): void
    {
        self::assertInstanceOf(Helper\FormInput::class, $this->helper, 'FormInput has not been properly delegated.');
    }
}
