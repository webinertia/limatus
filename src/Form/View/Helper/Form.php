<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\BootstrapInterface;
use Bootstrap\Form\View\Helper\FormHelperTrait;
use Laminas\Form\FieldsetInterface;
use Laminas\Form\FormInterface;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\View\Helper\Doctype;
use Laminas\View\Renderer\PhpRenderer;

use function array_key_exists;
use function array_merge;
use function assert;
use function method_exists;
use function sprintf;

/**
 * View helper for rendering Form objects
 */
class Form extends AbstractHelper
{
    use FormHelperTrait;

    /**
     * Attributes valid for this tag (form)
     *
     * @var array
     */
    protected $validTagAttributes = [
        'accept-charset' => true,
        'action'         => true,
        'autocomplete'   => true,
        'enctype'        => true,
        'method'         => true,
        'name'           => true,
        'novalidate'     => true,
        'target'         => true,
    ];

    /**
     * Invoke as function
     * $mode 'default' | 'inline' | 'grid'
     */
    public function __invoke(
        ?FormInterface $form = null,
        ?string $mode = BootstrapInterface::MODE_DEFAULT
        ): self|string {
        if (! $form) {
            return $this;
        }
        $this->setMode($mode);
        return $this->render($form);
    }

    /**
     * Render a form from the provided $form,
     */
    public function render(FormInterface $form): string
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $formContent = '';

        $renderer = $this->getView();
        assert($renderer instanceof PhpRenderer);
        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent .= $renderer->formCollection($element, true, $this->mode);
            } else {
                $formContent .= $renderer->formRow($element, null, null, null, $this->mode);
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }

    /**
     * Generate an opening form tag
     */
    public function openTag(?FormInterface $form = null): string
    {
        $doctype    = $this->getDoctype();
        $attributes = [];

        if (! (Doctype::HTML5 === $doctype || Doctype::XHTML5 === $doctype)) {
            $attributes = [
                'action' => '',
                'method' => 'get',
            ];
        }

        if ($form instanceof FormInterface) {
            $formAttributes = $form->getAttributes();
            if (! array_key_exists('id', $formAttributes) && array_key_exists('name', $formAttributes)) {
                $formAttributes['id'] = $formAttributes['name'];
            }
            $attributes = array_merge($attributes, $formAttributes);
        }

        if ($attributes) {
            return sprintf('<form %s>', $this->createAttributesString($attributes));
        }

        return '<form>';
    }

    /**
     * Generate a closing form tag
     */
    public function closeTag(): string
    {
        return '</form>';
    }
}
