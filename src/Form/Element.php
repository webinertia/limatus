<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\Element as BaseElement;
use Laminas\Stdlib\ArrayUtils;
use Traversable;

use function array_key_exists;

class Element extends BaseElement
{
    protected ?string $help;
    /** @var array $helpAttributes */
    protected array $helpAttributes = [];
    /**
     * @param  null|int|string   $name    Optional name for the element
     * @param  iterable $options Optional options for the element
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($name = null, iterable $options = [])
    {
        if (null !== $name) {
            $this->setName((string) $name);
            $this->setAttribute('id', $name);
        }

        if (! empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Set options for an element. Accepted options are:
     * - label: label to associate with the element
     * - label_attributes: attributes to use when the label is rendered
     * - label_options: label specific options
     *
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions(iterable $options)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (isset($options['help'])) {
            $this->setHelp($options['help']);
            unset($options['help']);
        }

        if (isset($options['help_attributes'])) {
            $this->setHelpAttributes($options['help_attributes']);
            unset($options['help_attributes']);
        }

        if (isset($options['label'])) {
            $this->setLabel($options['label']);
        }

        if (isset($options['label_attributes'])) {
            $this->setLabelAttributes($options['label_attributes']);
        }

        if (isset($options['label_options'])) {
            $this->setLabelOptions($options['label_options']);
        }

        $this->options = $options;

        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelpAttributes(iterable $arrayOrTraversable): self
    {
        foreach ($arrayOrTraversable as $key => $value) {
            $this->setHelpAttribute($key, $value);
        }
        return $this;
    }

    public function setHelpAttribute(string $key, string $value): self
    {
        $this->helpAttributes[$key] = $value;
        return $this;
    }

    public function getHelpAttributes(): array
    {
        return $this->helpAttributes;
    }

    public function getHelpAttribute(string $key): null|string
    {
        if (! isset($this->helpAttributes[$key])) {
            return null;
        }
        return $this->helpAttributes[$key];
    }

    public function hasHelpAttribute(string $key): bool
    {
        return array_key_exists($key, $this->helpAttributes);
    }

    public function removeHelpAttributes(array $keys): self
    {
        foreach ($keys as $key) {
            unset($this->helpAttributes[$key]);
        }
        return $this;
    }

    public function clearHelpAttributes(): self
    {
        $this->helpAttributes = [];
        return $this;
    }
}
