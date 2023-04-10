<?php

declare(strict_types=1);

namespace Bootstrap\Filter;

use Laminas\Filter\AbstractFilter;
use Laminas\Filter\Exception;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Stdlib\ErrorHandler;
use Traversable;

use function array_key_exists;
use function gettype;
use function is_array;
use function is_object;
use function is_string;
use function preg_match_all;
use function sprintf;

final class DelimitedStringFilter extends AbstractFilter
{
    protected string $start;
    protected string $end;
    protected bool $returnAllMatches;
    /**
     * Regular expression pattern, this pattern will return the string
     */
    protected string $pattern = '([a-zA-Z0-9_-]*)';
    /** The full expression to match against including $start and $end */
    protected string $regex;

    public function __construct(array|Traversable $options, bool $returnAllMatches = false)
    {
        $this->returnAllMatches = $returnAllMatches;
        if (! is_array($options) && ! $options instanceof Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                '"%s" expects an array or Traversable; received "%s"',
                __METHOD__,
                is_object($options) ? $options::class : gettype($options)
            ));
        }

        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (! array_key_exists('start', $options)) {
            throw new Exception\InvalidArgumentException('$options must contain a \'start\' key');
        }
        $this->setStart($options['start']);

        if (! array_key_exists('end', $options)) {
            throw new Exception\InvalidArgumentException('$options must contain a \'end\' key');
        }
        $this->setEnd($options['end']);

        if (array_key_exists('pattern', $options)) {
            $this->setPattern($options['pattern']);
        }
        $this->buildRegex();
    }

    public function __invoke(mixed $value): bool|string|array
    {
        return $this->filter($value);
    }

    /**
     * @param string $value
     * @throws Exception\InvalidArgumentException If there is a fatal error in pattern matching.
     * @return bool|string|array
     */
    public function filter($value)
    {
        if (! is_string($value)) {
            throw new Exception\InvalidArgumentException('$value must be a string');
        }
        $matches = [];

        ErrorHandler::start();
        $status = preg_match_all($this->regex, $value, $matches);
        $error  = ErrorHandler::stop();

        if (false === $status) {
            throw new Exception\InvalidArgumentException(
                "Internal error parsing the pattern '{$this->regex}'",
                0,
                $error
            );
        }

        if (! $status) {
            return false;
        }

        if (! is_array($matches[1])) {
            return false;
        }

        if (is_array($matches[1]) && is_string($matches[1][0]) && ! $this->returnAllMatches) {
            return $matches[1][0];
        }

        return $matches[1];
    }

    public function buildRegex(): self
    {
        $this->regex = '/' . $this->start . $this->pattern . $this->end . '/';
        return $this;
    }

    public function setReturnFlag(bool $returnAllMatches): self
    {
        if ($returnAllMatches !== $this->returnAllMatches) {
            $this->returnAllMatches = $returnAllMatches;
        }
        return $this;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    /** Sets the pattern option */
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * TODO: add checks for special characters to verify they are properly escaped
     */
    public function setStart(string $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * TODO: add checks for special characters to verify they are properly escaped
     */
    public function setEnd(string $end): self
    {
        $this->end = $end;
        return $this;
    }

    public function getEnd(): string
    {
        return $this->end;
    }
}
