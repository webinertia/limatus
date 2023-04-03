<?php

declare(strict_types=1);

namespace Bootstrap\Form\View\Helper;

use Bootstrap\Filter\DelimitedStringFilter;
use Bootstrap\Form\BootstrapElementInterface;
use Bootstrap\Form\Element;
use Laminas\Form\Element as BaseElement;
use Laminas\Form\ElementInterface;
use Laminas\Form\FormInterface;
use Laminas\Form\View\Helper\AbstractHelper;

use function array_key_exists;
use function method_exists;
use function str_contains;
use function ucfirst;

class Bootstrapper extends AbstractHelper
{
    public const VHC_KEY            = 'bootstrap';
    public const DEFAULT_MODE       = 'default';
    public const INLINE_MODE        = 'inline';
    public const GRID_MODE          = 'grid';
    public const INLINE_LABEL_CLASS = 'sr-only';
    public const INLINE_FORM_CLASS  = 'form-inline';
    public const OPENING_KEY        = 'opening';
    public const SEPARATOR_KEY      = 'separator';
    public const CLOSING_KEY        = 'closing';

    protected ?ElementInterface $element;
    protected bool $enabled = false;
    protected ?string $mode;
    protected ?array $config;

    protected array $typeToClassMap = [
        'select'         => 'form-control',
        'email'          => 'form-control',
        'text'           => 'form-control',
        'button'         => 'btn',
        'checkbox'       => 'form-check-input',
        'file'           => 'form-control-file',
        'image'          => '',
        'password'       => 'form-control',
        'radio'          => 'form-check-input',
        'reset'          => 'btn',
        'select'         => 'form-control',
        'submit'         => 'btn',
        'date'           => 'form-control',
        'datetime'       => 'form-control',
        'datetime-local' => 'form-control',
        'email'          => 'form-control',
        'month'          => 'form-control',
        'number'         => 'form-control',
        'range'          => 'form-control',
        'search'         => 'form-control',
        'tel'            => 'form-control',
        'time'           => 'form-control',
        'url'            => 'form-control',
        'week'           => 'form-control',
        'textarea'       => 'form-control',
    ];

    public function __construct(array $config)
    {
        $this->config  = $config;
    }

    public function __invoke(): self
    {
        return $this;
    }

    public function bootstrapForm(FormInterface $form, string $mode): void
    {
        if (! $form->hasAttribute('id') && $form->hasAttribute('name')) {
            $form->setAttribute('id', self::getId($form));
        }
        if ($mode === self::INLINE_MODE) {
            if ($form->hasAttribute('class')) {
                $form->setAttribute('class', ($form->getAttribute('class') . ' ' . self::INLINE_FORM_CLASS));
            } else {
                $form->setAttribute('class', self::INLINE_FORM_CLASS);
            }
        }
    }

    public function bootstrapElement(ElementInterface $element, string $mode): void
    {
        if (! $element->hasAttribute('id')) {
            $id = $this->getId($element);
            if ($id !== null) {
                $element->setAttribute('id', $id);
            }
        }
        // we do not have the same features available here,
        assert($element instanceof BaseElement);
        switch (true) {
            case self::INLINE_MODE === $mode:
            case self::GRID_MODE === $mode:
                $labelAttributes = $element->getLabelAttributes();
                if (! array_key_exists('class', $labelAttributes)) {
                    $element->setLabelAttributes(['class' => self::INLINE_LABEL_CLASS]);
                }
                if ($element->getLabel() !== null) {
                    $element->setAttribute('placeholder', $element->getLabel());
                } elseif($id !== null) {
                    $element->setAttribute('placeholder', ucfirst($id));
                }
                break;

            default:
                # code...
                break;
        }
        $this->bootstrapElementClassString($element);
    }

    public function wrapElement(ElementInterface $element, string $mode, string $markup): string
    {
        // handle bootstrap wrapping
        if (
            $element instanceof BootstrapElementInterface
            && method_exists($element, 'getBootstrapAttributes')
        ) {
                assert($element instanceof Element);
                $wrapper = $element->getWrapper();
                $markup = sprintf(
                    $wrapper,
                    $this->createAttributesString($element->getBootstrapAttributes()),
                    $markup
                );
            } else {
                $filter         = new DelimitedStringFilter(['start' => '\\[', 'end' => '\\]']);
                $elementName    = ($tempName = $filter->filter($element->getName())) ? $tempName : $element->getName();
                $configTemplate = $this->templateHelper($elementName, $mode);
                if (is_array($configTemplate)) {
                    $configTemplate = implode($configTemplate);
                }
                $markup = sprintf(
                    $configTemplate,
                    $markup
                );
            }
            return $markup;
    }

    public function enabled(ElementInterface $element): bool
    {
        if (
            $element instanceof BootstrapElementInterface
            || $this->classCheck($element)
        ) {
            $this->enabled = true;
        }
        return $this->enabled;
    }

    public function bootstrapElementClassString(ElementInterface $element): void
    {
        $class = '';
        if ($element->hasAttribute('type')) {
            $class = $this->getTypeClass($element->getAttribute('type'));
        }
        if (! $element->hasAttribute('class')) {
            // Note: we do not have to worry with the form-check-inline style classes here, they are set on the div
            $element->setAttribute('class', $class);
            return;
        }
        if ($element->hasAttribute('class')) {
            $classString = $element->getAttribute('class');
            if ($class !== '' && ! str_contains($classString, $class)) {
                $classString = $class . ' ' . $classString;
                $element->setAttribute('class', $classString);
            }
        }
    }

    protected function getTypeClass(string $type): string|null
    {
        if (array_key_exists($type, $this->typeToClassMap)) {
            return $this->typeToClassMap[$type];
        }
        return null;
    }

    /**
     * todo Expand this to use a regex check for more complex class identifiers
     * col-2, mb-2, my-4, row, form-row
     *
     * @param ElementInterface $element
     * @return bool
     */
    protected function classCheck(ElementInterface $element): bool
    {
        if (! $element->hasAttribute('class')) {
            return false;
        }
        $classes = explode(' ', $element->getAttribute('class'));
        foreach ($classes as $class) {
            if (in_array($class, $this->config['supported_classes'])) {
                return true;
            }
        }

        return false;
    }

    public function templateHelper(
        string $elementName,
        string $mode = self::DEFAULT_MODE
    ): array|null {
        $tpl = [];
        $config = $this->getConfig();
        if (isset($config['templates'][$mode][$elementName])) {
            $tpl += $config['templates'][$mode][$elementName];
        }
        return $tpl;
    }

    public function getConfig(?string $key = null, int $depth = 0): array|string
    {
        // Debug this code
        if ($key !== null) {
            if (array_key_exists($key, $this->config)) {
                return $this->config['view_helper_config'][self::VHC_KEY][$key];
            }
        }
        return $this->config;
    }

    public function setBootstrapMarkup(array $markup): self
    {
        $this->bootstrapMarkup = $markup;
        return $this;
    }

    public function getBootstrapMarkup(): array
    {
        return $this->bootstrapMarkup;
    }

    public function enable(): void
    {
        if (! $this->enabled) {
            $this->enabled = true;
        }
    }

    public function disable(): void
    {
        if ($this->enabled) {
            $this->enabled = false;
        }
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
}
