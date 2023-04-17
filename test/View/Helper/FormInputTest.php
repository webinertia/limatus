<?php

declare(strict_types=1);

namespace LimatusTest\Form\View\Helper;

use Laminas\Form\View\Helper\FormInput;
use Limatus\Form\View\Helper;
use LimatusTest\Form\View\Helper\AbstractCommonTestCase;

class FormInputTest extends AbstractCommonTestCase
{
    protected function setUp(): void
    {
        $this->helper = new Helper\FormInput(new FormInput());
        parent::setUp();
    }

    public function testFormInputIsDelegated(): void
    {
        self::assertInstanceOf(
            Helper\FormInput::class,
            $this->renderer->plugin('forminput'),
            'FormInput has not been properly delegated.'
        );
    }
}
