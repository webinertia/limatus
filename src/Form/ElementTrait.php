<?php

declare(strict_types=1);

namespace Bootstrap\Form;

use Bootstrap\Form\ModeAwareInterface;
use Laminas\Stdlib\ArrayUtils;
use Traversable;

use function array_key_exists;

trait ElementTrait
{
    protected array $bootstrapAttributes  = [];
    protected array $horizontalAttributes = [];
    protected array $helpAttributes       = [];
    protected string $help                = '';
    protected string $mode                = ModeAwareInterface::DEFAULT_MODE;
    protected string $plaintextClass      = 'form-control-plaintext';
    protected string $wrapper             = '';

    public function getMode(): string
    {
        return $this->mode;
    }

    public function hasMode(): bool
    {
        return isset($this->mode);
    }

    public function setMode(string $mode): ModeAwareInterface
    {
        $this->mode = $mode;
        return $this;
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
     * All of the Laminas defaults plus
     * - mode Determines which rendering mode the helper will use to build markup
     * - bootstrap_attributes attributes for the div wrapper for the element
     * - help The help text message string used for the element
     * - help_attributes Attributes for the help element markup
     *
     * @return $this
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions(iterable $options)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (isset($options['mode'])) {
            $this->setMode($options['mode']);
            unset($options['mode']);
        }

        if (isset($options['bootstrap_attributes'])) {
            $this->setBootstrapAttributes($options['bootstrap_attributes']);
            unset($options['bootstrap_attributes']);
        }

        if (isset($options['horizontal_attributes'])) {
            $this->setHorizontalAttributes($options['horizontal_attributes']);
            unset($options['horizontal_attributes']);
        }

        if (isset($options['help'])) {
            $this->setHelp($options['help']);
            unset($options['help']);
        }

        if (isset($options['help_attributes'])) {
            $this->setHelpAttributes($options['help_attributes']);
            unset($options['help_attributes']);
        }

        parent::setOptions($options);

        return $this;
    }

    /**
     * Set a single element attribute
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setBootstrapAttribute(string $key, $value): self
    {
        if ($key === 'wrapper') {
            $this->setWrapper($value);
            return $this;
        }

        $this->bootstrapAttributes[$key] = $value;
        return $this;
    }

    /**
     * Retrieve a single element attribute
     *
     * @return mixed|null
     */
    public function getBootstrapAttribute(string $key): string|null
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
    public function removeBootstrapAttribute(string $key): self
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

    /** Set many attributes at once */
    public function setBootstrapAttributes(iterable $arrayOrTraversable): self
    {
        foreach ($arrayOrTraversable as $key => $value) {
            $this->setBootstrapAttribute($key, $value);
        }
        return $this;
    }

    /** Retrieve all attributes at once */
    public function getBootstrapAttributes(): array
    {
        return $this->bootstrapAttributes;
    }

    /** Remove attribute */
    public function removeBootstrapAttributes(array $keys): self
    {
        foreach ($keys as $key) {
            unset($this->bootstrapAttributes[$key]);
        }

        return $this;
    }

    /** Clear all attributes */
    public function clearBootstrapAttributes(): self
    {
        $this->bootstrapAttributes = [];
        return $this;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;
        return $this;
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function setHelpAttribute(string $key, string $value): self
    {
        $this->helpAttributes[$key] = $value;
        return $this;
    }

    public function getHelpAttribute(string $key): string|null
    {
        if (! isset($this->helpAttributes[$key])) {
            return null;
        }
        return $this->helpAttributes[$key];
    }

    public function setHelpAttributes(iterable $arrayOrTraversable): self
    {
        foreach ($arrayOrTraversable as $key => $value) {
            $this->setHelpAttribute($key, $value);
        }
        return $this;
    }

    public function getHelpAttributes(): array
    {
        return $this->helpAttributes;
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

    public function setHorizontalAttributes(array $horizontalAttributes): self
    {
        foreach ($horizontalAttributes as $key => $value) {
            if ($key === 'class') {
                $this->setHorizontalAttribute($key, $value);
            }
        }
        return $this;
    }

    public function getHorizontalAttributes(): array
    {
        return $this->horizontalAttributes;
    }

    public function setHorizontalAttribute(string $key, string $value): self
    {
        // silenty skip everything except the class attribute
        if ($key === 'class') {
            $this->horizontalAttributes[$key] = $value;
        }
        return $this;
    }
}
