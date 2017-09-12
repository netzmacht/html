<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html;

use Netzmacht\Html\Exception\InvalidArgumentException;
use Traversable;

/**
 * Class Attributes
 *
 * @package Netzmacht\FormHelper\Html
 */
class Attributes implements CastsToString, \IteratorAggregate, \ArrayAccess
{
    /**
     * Array of attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * List of boolean attributes.
     *
     * @var array
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
     * @param array $attributes Attributes.
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
     * @throws InvalidArgumentException When an invalid value is given.
     */
    public function setAttribute($name, $value)
    {
        $this->guardValidName($name);

        if ($name == 'class') {
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
    public function getAttribute($name, $default = null)
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
     *
     * @return bool
     */
    public function hasAttribute($name)
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
    public function removeAttribute($name)
    {
        if ($name == 'class') {
            $this->attributes['class'] = [];
        } else {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * Add a map of attributes.
     *
     * @param array $attributes Map of attributes.
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
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Check if an class exists.
     *
     * @param string $name Class name.
     *
     * @return bool
     */
    public function hasClass($name)
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
     * @throws InvalidArgumentException
     */
    public function addClass($class)
    {
        // split multiple classes
        if (strpos($class, ' ') !== false) {
            $classes = array_filter(explode(' ', $class));

            foreach ($classes as $class) {
                $this->addClass($class);
            }

            return $this;
        }

        if ($class && !$this->hasClass($class)) {
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
     * @throws InvalidArgumentException When an invalid id value is given.
     */
    public function setId($value)
    {
        $this->guardValidId($value);
        $this->setAttribute('id', $value);

        return $this;
    }

    /**
     * Get the id.
     *
     * @return string
     */
    public function getId()
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
    public function removeClass($name)
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
     * @param array $classes List of classes.
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
        return new \ArrayIterator($this->attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $buffer   = '';
        $template = ' %s="%s"';

        foreach ($this->attributes as $name => $value) {
            if (in_array($name, self::$booleanAttributes)) {
                if ($value) {
                    $buffer .= ' ' . htmlspecialchars($name);
                }
            } elseif ($name == 'class') {
                if (!empty($value)) {
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


    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->generate();
    }

    /**
     * Guard that a name is valid.
     *
     * @param string $name Name of an attribute.
     *
     * @throws Exception\InvalidArgumentException
     */
    private function guardValidName($name)
    {
        if (!preg_match('@^([^\t\n\f \/>"\'=]+)$@', $name)) {
            throw new InvalidArgumentException('Invalid attribute name given', 0, null, $name);
        }
    }

    /**
     * Guard that value is an array.
     *
     * @param mixed  $value Given value.
     * @param string $error Error message.
     *
     * @throws Exception\InvalidArgumentException
     */
    private function guardIsArray($value, $error = 'Value has to be an array')
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException($error, 0, null, $value);
        }
    }

    /**
     * Guard that the id is valid.
     *
     * @param string $value Given value.
     *
     * @throws Exception\InvalidArgumentException
     */
    private function guardValidId($value)
    {
        if ($value === null) {
            return;
        }

        if (!is_string($value)) {
            throw new InvalidArgumentException('Css ID has to be a string.', 0, null, $value);
        }

        if (strlen($value) < 1) {
            throw new InvalidArgumentException('Css ID requires at least one character.', 0, null, $value);
        }

        if (!preg_match('/^[^\s]*$/s', $value)) {
            throw new InvalidArgumentException('Css ID cannot contain a space character.', 0, null, $value);
        }
    }
}
