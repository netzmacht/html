<?php

declare(strict_types=1);

namespace Netzmacht\Html;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Netzmacht\Html\Exception\InvalidArgumentException;
use Traversable;

use function array_filter;
use function array_map;
use function array_search;
use function array_values;
use function explode;
use function htmlspecialchars;
use function implode;
use function in_array;
use function is_array;
use function preg_match;
use function sprintf;
use function strpos;
use function trim;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class Attributes implements CastsToString, IteratorAggregate, ArrayAccess
{
    /**
     * Array of attributes.
     *
     * @var array<string,mixed>
     */
    private array $attributes;

    /**
     * List of boolean attributes.
     */
    private const BOOLEAN_ATTRIBUTES = [
        'compact',
        'declare',
        'defer',
        'disabled',
        'formnovalidate',
        'multiple',
        'nowrap',
        'novalidate',
        'ismap',
        'itemscope',
        'readonly',
        'required',
        'selected',
    ];

    /** @param array<string,mixed> $attributes Attributes. */
    public function __construct(array $attributes = [])
    {
        $this->attributes = [
            'class' => [],
        ];

        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * Set an attribute.
     *
     * @param string $name  Name of the attribute.
     * @param mixed  $value Value of the attribute.
     *
     * @return $this
     *
     * @throws InvalidArgumentException When an invalid value is given.
     */
    public function setAttribute(string $name, mixed $value): self
    {
        $this->guardValidName($name);

        if ($name === 'class') {
            $this->guardIsArray($value, 'Classes have to be set as array');
            $this->addClasses($value);
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Get an attribute.
     *
     * @param string $name    Attribute name.
     * @param mixed  $default Return default value if attribute does not exist.
     */
    public function getAttribute(string $name, mixed $default = null): mixed
    {
        if ($this->hasAttribute($name)) {
            return $this->attributes[$name];
        }

        return $default;
    }

    /**
     * Check if attribute exists.
     *
     * @param string $name Attribute name.
     */
    public function hasAttribute(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Remove an attribute.
     *
     * @param string $name Attribute name.
     *
     * @return $this
     */
    public function removeAttribute(string $name): self
    {
        if ($name === 'class') {
            $this->attributes['class'] = [];
        } else {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * Add a map of attributes.
     *
     * @param array<string,mixed> $attributes Map of attributes.
     *
     * @return $this
     */
    public function addAttributes(array $attributes): self
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Get all attributes as array.
     *
     * @return array<string,mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Check if an class exists.
     *
     * @param string $name Class name.
     */
    public function hasClass(string $name): bool
    {
        $classes = $this->getAttribute('class');

        return in_array($name, $classes, true);
    }

    /**
     * Add a class.
     *
     * @param string $class Classes.
     *
     * @return $this
     *
     * @throws InvalidArgumentException When an invalid class value is given.
     */
    public function addClass(string $class)
    {
        // split multiple classes
        if (strpos($class, ' ') !== false) {
            $classes = array_filter(explode(' ', $class));

            foreach ($classes as $class) {
                $this->addClass($class);
            }

            return $this;
        }

        if ($class && ! $this->hasClass($class)) {
            $this->attributes['class'][] = $class;
        }

        return $this;
    }

    /**
     * Set the id.
     *
     * @param string $value Element id.
     *
     * @return $this
     *
     * @throws InvalidArgumentException When an invalid id value is given.
     */
    public function setId(string $value): self
    {
        $this->guardValidId($value);
        $this->setAttribute('id', $value);

        return $this;
    }

    /**
     * Get the id.
     */
    public function getId(): string
    {
        return $this->getAttribute('id');
    }

    /**
     * Remove a class.
     *
     * @param string $name Class name.
     *
     * @return $this
     */
    public function removeClass(string $name)
    {
        $index = array_search($name, $this->attributes['class'], true);

        if ($index !== false) {
            unset($this->attributes['class'][$index]);
            $this->attributes['class'] = array_values($this->attributes['class']);
        }

        return $this;
    }

    /**
     * Add a list of classes.
     *
     * @param list<string> $classes List of classes.
     *
     * @return $this
     */
    public function addClasses(array $classes): self
    {
        foreach ($classes as $class) {
            $this->addClass($class);
        }

        return $this;
    }

    /** @return Traversable<string,mixed> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->attributes);
    }

    public function generate(): string
    {
        $buffer   = '';
        $template = ' %s="%s"';

        foreach ($this->attributes as $name => $value) {
            if (in_array($name, self::BOOLEAN_ATTRIBUTES, true)) {
                if ($value) {
                    $buffer .= ' ' . htmlspecialchars($name);
                }
            } elseif ($name === 'class') {
                if (! empty($value)) {
                    $value = array_map('htmlspecialchars', $value);
                    $value = implode(' ', $value);

                    $buffer .= sprintf($template, $name, $value);
                }
            } else {
                $buffer .= sprintf($template, $name, htmlspecialchars((string) $value));
            }
        }

        return trim($buffer);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->hasAttribute($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->removeAttribute($offset);
    }

    public function __toString(): string
    {
        return $this->generate();
    }

    /**
     * Guard that a name is valid.
     *
     * @param string $name Name of an attribute.
     *
     * @throws InvalidArgumentException When an invalid attribute value is given.
     */
    private function guardValidName(string $name): void
    {
        if (! preg_match('@^([^\t\n\f \/>"\'=]+)$@', $name)) {
            throw new InvalidArgumentException('Invalid attribute name given', 0, null, $name);
        }
    }

    /**
     * Guard that value is an array.
     *
     * @param mixed  $value Given value.
     * @param string $error Error message.
     *
     * @throws InvalidArgumentException When value is not an array.
     */
    private function guardIsArray(mixed $value, string $error = 'Value has to be an array'): void
    {
        if (! is_array($value)) {
            throw new InvalidArgumentException($error, 0, null, $value);
        }
    }

    /**
     * Guard that the id is valid.
     *
     * @throws InvalidArgumentException When an invalid css id value is given.
     */
    private function guardValidId(string $value): void
    {
        if ($value === '') {
            throw new InvalidArgumentException('Css ID requires at least one character.', 0, null, $value);
        }

        if (! preg_match('/^[^\s]*$/s', $value)) {
            throw new InvalidArgumentException('Css ID cannot contain a space character.', 0, null, $value);
        }
    }
}
