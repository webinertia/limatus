<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Laminas\Form\Element as BaseElement;
use Laminas\Stdlib\ArrayUtils;
use Traversable;

use function array_key_exists;

class Element extends BaseElement implements BootstrapElementInterface
{
    /** @var array<string, string> $attributes */
    protected $attributes = ['class' => 'form-control'];
    protected array $bootstrapAttributes = [];
    protected array $bootstrapOptions = [];
    protected ?string $wrapper;
    protected ?string $help;
    protected string $plaintextClass = 'form-control-plaintext';
    /** @var array<string, string> $helpAttributes */
    protected $helpAttributes = [];
    /**
     * @param  null|int|string   $name    Optional name for the element
     * @param  iterable $options Optional options for the element
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($name = null, iterable $options = [])
    {
        if (null !== $name) {
            $this->setName((string) $name);
            //$this->setAttribute('id', $name);
        }

        if (! empty($options)) {
            $this->setOptions($options);
        }
    }

    public function setWrapper(string $wrapper): void
    {
        $this->wrapper = $wrapper;
    }

    public function getWrapper(): ?string
    {
        return $this->wrapper;
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

        if (isset($options['bootstrap_attributes'])) {
            $this->setBootstrapAttributes($options['bootstrap_attributes']);
            unset($options['bootstrap_attributes']);
        }

        if (isset($options['bootstrap_options'])) {
            $this->setBootstrapOptions($options['bootstrap_options']);
            unset($options['bootstrap_options']);
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

    /**
     * Set a single element attribute
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute(string $key, $value)
    {
        // Do not include the value in the list of attributes
        if ($key === 'value') {
            $this->setValue($value);
            return $this;
        }

        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Set a single element attribute
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setBootstrapAttribute(string $key, $value)
    {
        // Do not include the value in the list of attributes
        if ($key === 'value') {
            $this->setValue($value);
            return $this;
        }
        if ($key === 'wrapper') {
            $this->setWrapper($value);
            return $this;
        }
        if ($key === 'class' && $this->hasAttribute('class')) {
                $class = $this->getAttribute($key);
                $value = $class . ' ' . $value;
        }
        $this->bootstrapAttributes[$key] = $value;
        return $this;
    }

    /**
     * Retrieve a single element attribute
     *
     * @return mixed|null
     */
    public function getBootstrapAttribute(string $key)
    {
        if (! isset($this->bootstrapAttributes[$key])) {
            return null;
        }

        return $this->bootstrapAttributes[$key];
    }

    /**
     * Remove a single attribute
     *
     * @return $this
     */
    public function removeBootstrapAttribute(string $key)
    {
        unset($this->bootstrapAttributes[$key]);
        return $this;
    }

    /**
     * Does the element has a specific attribute ?
     */
    public function hasBootstrapAttribute(string $key): bool
    {
        return array_key_exists($key, $this->bootstrapAttributes);
    }

    /**
     * Set many attributes at once
     *
     * Implementation will decide if this will overwrite or merge.
     *
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function setBootstrapAttributes(iterable $arrayOrTraversable)
    {
        foreach ($arrayOrTraversable as $key => $value) {
            $this->setBootstrapAttribute($key, $value);
        }
        return $this;
    }

    /**
     * Retrieve all attributes at once
     */
    public function getBootstrapAttributes(): array
    {
        return $this->bootstrapAttributes;
    }

    /**
     * Remove many attributes at once
     *
     * @param array $keys
     * @return $this
     */
    public function removeBootstrapAttributes(array $keys)
    {
        foreach ($keys as $key) {
            unset($this->bootstrapAttributes[$key]);
        }

        return $this;
    }

    /**
     * Clear all attributes
     *
     * @return $this
     */
    public function clearBootstrapAttributes()
    {
        $this->bootstrapAttributes = [];
        return $this;
    }

    /**
     * supported key|values
     * display_as_plaintext|bool
     */
    public function setBootstrapOption(string $key, string $value): self
    {
        $this->bootstrapOptions[$key] = $value;
        return $this;
    }

    public function setBootstrapOptions(array $options): self
    {
        foreach ($options as $key => $value) {
            $this->bootstrapOptions[$key] = $value;
        }
        return $this;
    }

    public function getBootstrapOption(string $key): string|bool|null
    {
        if (array_key_exists($key, $this->bootstrapOptions)) {
            return $this->bootstrapOptions[$key];
        }
        return null;
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
