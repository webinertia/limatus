<?php

declare(strict_types=1);

namespace Bootstrap\Filter;

use Laminas\Filter\AbstractFilter;
use Laminas\Filter\Exception;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Stdlib\ErrorHandler;
use Traversable;

use function array_key_exists;
use function is_string;
use function preg_match_all;

final class DelimitedStringFilter extends AbstractFilter
{
    public const INVALID   = 'regexInvalid';
    public const NOT_MATCH = 'regexNotMatch';
    public const ERROROUS  = 'regexErrorous';

    protected string $start;
    protected string $end;
    protected bool $returnAllMatches;
    /**
     * Regular expression pattern
     *
     * @var string
     */
    protected $pattern = '([a-zA-Z0-9_-]*)';

    /**
     * Sets validator options
     *
     * @param  string|array|Traversable $pattern
     * @throws Exception\InvalidArgumentException On missing 'pattern' parameter.
     */
    public function __construct(array $options, bool $returnAllMatches = false)
    {
        $this->returnAllMatches = $returnAllMatches;
        parent::setOptions($options);
    }

    /**
     * Returns the pattern option
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Sets the pattern option
     *
     * @param  string $pattern
     * @throws Exception\InvalidArgumentException If there is a fatal error in pattern matching.
     * @return $this Provides a fluent interface
     */
    public function setPattern(string $pattern)
    {
        ErrorHandler::start();
       // $this->pattern =
        $this->pattern = '/' . $this->start . $pattern . $this->end . '/';
        $status        = preg_match_all($this->pattern, 'Test');
        $error         = ErrorHandler::stop();

        if (false === $status) {
            throw new Exception\InvalidArgumentException(
                "Internal error parsing the pattern '{$this->pattern}'",
                0,
                $error
            );
        }

        return $this;
    }

    public function setStart(string $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function getStart(): string
    {
        return $this->start;
    }

    public function setEnd(string $end): self
    {
        $this->end = $end;
        return $this;
    }

    public function getEnd(): string
    {
        return $this->end;
    }

    /**
     * @param string $value
     * @return string|array
     */
    public function filter($value)
    {
        if (! is_string($value)) {
            throw new Exception\InvalidArgumentException('$value must be a string');
        }
        $matches = [];
        $regex = '/' . $this->start . $this->pattern . $this->end . '/';
        ErrorHandler::start();
        $status = preg_match_all($regex, $value, $matches);
        ErrorHandler::stop();
        if (false === $status) {
            return false;
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
}
