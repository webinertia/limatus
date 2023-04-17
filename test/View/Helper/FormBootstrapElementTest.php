<?php

declare(strict_types=1);

namespace LimatusTest\Form\View\Helper;

use Limatus\Form\Element;
use Limatus\Form\View\Helper;
use LimatusTest\Form\View\Helper\AbstractCommonTestCase;

class FormBootstrapElementTest extends AbstractCommonTestCase
{
    protected function setUp(): void
    {
        $this->helper = new Helper\FormBootstrapElement();
        parent::setUp();
    }

    public function testFormBootstrappedElementCanRenderBootstrapElement(): void
    {
        $options = [
            'attributes' => [
                'class'            => 'form-control test',
                'aria-describedby' => 'testHelp',
            ],
            'options'    => [
                'label'                => 'Test',
                'help'                 => 'Testing is great.',
                'bootstrap_attributes' => [
                    'class' => 'form-group col-md-4',
                ],
                'help_attributes'      => [
                    'class' => 'form-text text-muted',
                ],
            ],
        ];
        // get what we need
        $element     = new Element\Text('test', $options);
        $basehelper  = $this->renderer->plugin('formrow');
        $errorHelper = $this->renderer->plugin('formelementerrors');
        $markup      = $this->helper->render(
            $element,
            $basehelper->render($element),
            $errorHelper->render($element)
        );
        self::assertStringContainsString('<div', $markup);
    }
}
