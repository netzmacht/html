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
 * @package Netzmacht\FormHelper\Html
 */
class Attributes implements CastsToString, \IteratorAggregate, \ArrayAccess
{
	/**
	 * @var array
	 */
	protected $attributes;

	/**
	 * @var array
	 */
	private static $booleanAttributes = array(
		'compact',
		'declare',
		'defer',
		'disabled',
		'formnovalidate',
		'multiple',
		'nowrap',
		'novalidate',
		'ismap',
		'readonly',
		'required',
		'selected',
	);


	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes=array())
	{
		$this->attributes = array(
			'class' => array(),
		);

		foreach($attributes as $name => $value) {
			$this->setAttribute($name, $value);
		}
	}


	/**
	 * @param $name
	 * @param $value
	 * @return $this
	 * @throws InvalidArgumentException
	 */
	public function setAttribute($name, $value)
	{
		$this->guardValidName($name);

		if($name == 'class') {
			$this->guardIsArray($value, 'Classes have to be set as array');
			$this->addClasses($value);
		}
		else {
			$this->attributes[$name] = $value;
		}

		return $this;
	}


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAttribute($name, $default=null)
	{
		if($this->hasAttribute($name)) {
			return $this->attributes[$name];
		}

		return $default;
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function hasAttribute($name)
	{
		return isset($this->attributes[$name]);
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function removeAttribute($name)
	{
		if($name == 'class') {
			$this->attributes['class'] = array();
		}
		else {
			unset($this->attributes[$name]);
		}

		return $this;
	}


	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function addAttributes(array $attributes)
	{
		foreach($attributes as $name => $value) {
			$this->setAttribute($name, $value);
		}

		return $this;
	}


	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function hasClass($name)
	{
		$classes = $this->getAttribute('class');

		return in_array($name, $classes);
	}


	/**
	 * @param $class
	 * @return $this
	 * @throws InvalidArgumentException
	 */
	public function addClass($class)
	{
		// split multiple classes
		if(strpos($class, ' ') !== false) {
			$classes = array_filter(explode(' ', $class));

			foreach($classes as $class) {
				$this->addClass($class);
			}

			return $this;
		}

		if($class && !$this->hasClass($class)) {
			$this->attributes['class'][] = $class;
		}

		return $this;
	}


	/**
	 * @param $value
	 * @return $this
	 * @throws InvalidArgumentException
	 */
	public function setId($value)
	{
		$this->guardValidId($value);
		$this->setAttribute('id', $value);

		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->getAttribute('id');
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function removeClass($name)
	{
		$index = array_search($name, $this->attributes['class']);

		if($index !== false) {
			unset($this->attributes['class'][$index]);
			$this->attributes['class'] = array_values($this->attributes['class']);
		}

		return $this;
	}

	/**
	 * @param array $classes
	 * @return $this
	 */
	public function addClasses(array $classes)
	{
		foreach($classes as $class) {
			$this->addClass($class);
		}

		return $this;
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->attributes);
	}


	/**
	 * @return string
	 */
	public function generate()
	{
		$buffer   = '';
		$template = ' %s="%s"';

		foreach($this->attributes as $name => $value) {
			if(in_array($name, self::$booleanAttributes)) {
				if($value) {
					$buffer .= ' ' . htmlspecialchars($name);
				}

			}
			elseif($name == 'class') {
				if(!empty($value)) {
					$value = array_map('htmlspecialchars', $value);
					$value = implode(' ', $value);

					$buffer .= sprintf($template, $name, $value);
				}
			}
			else {
				$buffer .= sprintf($template, $name, htmlspecialchars((string) $value));
			}
		}

		return trim($buffer);
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset)
	{
		return $this->hasAttribute($offset);
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset)
	{
		return $this->getAttribute($offset);
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->setAttribute($offset, $value);
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		$this->removeAttribute($offset);
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

	/**
	 * @param $name
	 * @throws Exception\InvalidArgumentException
	 */
	private function guardValidName($name)
	{
		if(!preg_match('@^([^\t\n\f \/>"\'=]+)$@', $name)) {
			throw new InvalidArgumentException('Invalid attribute name given', 0, null, $name);
		}
	}

	/**
	 * @param $value
	 * @param string $error
	 * @throws Exception\InvalidArgumentException
	 */
	private function guardIsArray($value, $error='Value has to be an array')
	{
		if(!is_array($value)) {
			throw new InvalidArgumentException($error, 0, null, $value);
		}
	}

	/**
	 * @param $value
	 * @throws Exception\InvalidArgumentException
	 */
	private function guardValidId($value)
	{
		if($value === null) {
			return;
		}

		if(!is_string($value)) {
			throw new InvalidArgumentException('Css ID has to be a string.', 0, null, $value);
		}

		if(strlen($value) < 1) {
			throw new InvalidArgumentException('Css ID requires at least one character.', 0, null, $value);
		}

		if(!preg_match('/^[^\s]*$/s', $value)) {
			throw new InvalidArgumentException('Css ID cannot contain a space character.', 0, null, $value);
		}
	}

}