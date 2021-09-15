<?php

declare(strict_types=1);

namespace Netzmacht\Html;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Netzmacht\Html\Exception\InvalidArgumentException;

use function array_filter;
use function array_map;
use function array_search;
use function array_values;
use function explode;
use function htmlspecialchars;
use function implode;
use function in_array;
use function is_array;
use function is_string;
use function preg_match;
use function sprintf;
use function strlen;
use function strpos;
use function trim;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Attributes implements CastsToString, IteratorAggregate, ArrayAccess
{
    /**
     * Array of attributes.
     *
     * @var array<string,mixed>
     */
    protected $attributes;

    /**
     * List of boolean attributes.
     *
     * @var list<string>
     */
    private static $booleanAttributes = [
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

    /**
     * Construct.
     *
     * @param array<string,mixed> $attributes Attributes.
     */
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
    public function setAttribute(string $name, $value)
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
     *
     * @return mixed
     */
    public function getAttribute(string $name, $default = null)
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
    public function removeAttribute(string $name)
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
    public function addAttributes(array $attributes)
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

        return in_array($name, $classes);
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
    public function setId(string $value)
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
        $index = array_search($name, $this->attributes['class']);

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
    public function addClasses(array $classes)
    {
        foreach ($classes as $class) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }

    public function generate(): string
    {
        $buffer   = '';
        $template = ' %s="%s"';

        foreach ($this->attributes as $name => $value) {
            if (in_array($name, self::$booleanAttributes)) {
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

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
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
    private function guardIsArray($value, string $error = 'Value has to be an array'): void
    {
        if (! is_array($value)) {
            throw new InvalidArgumentException($error, 0, null, $value);
        }
    }

    /**
     * Guard that the id is valid.
     *
     * @param string $value Given value.
     *
     * @throws InvalidArgumentException When an invalid css id value is given.
     */
    private function guardValidId(string $value): void
    {
        if ($value === null) {
            return;
        }

        if (! is_string($value)) {
            throw new InvalidArgumentException('Css ID has to be a string.', 0, null, $value);
        }

        if (strlen($value) < 1) {
            throw new InvalidArgumentException('Css ID requires at least one character.', 0, null, $value);
        }

        if (! preg_match('/^[^\s]*$/s', $value)) {
            throw new InvalidArgumentException('Css ID cannot contain a space character.', 0, null, $value);
        }
    }
}
