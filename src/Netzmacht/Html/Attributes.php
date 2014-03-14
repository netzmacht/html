<?php

namespace Netzmacht\Html;

use Traversable;

/**
 * Class Attributes
 * @package Netzmacht\FormHelper\Html
 */
class Attributes implements GenerateInterface, \IteratorAggregate, \ArrayAccess
{

	/**
	 * All standalone elements
	 * @var array
	 */
	protected static $standalone = array(
		'area',
		'base',
		'basefont',
		'br',
		'col',
		'frame',
		'hr',
		'img',
		'input',
		'isindex',
		'link',
		'meta',
		'novalidate',
		'param'
	);

	/**
	 * @var array
	 */
	protected $attributes;


	/**
	 * @param array $attributes
	 */
	function __construct(array $attributes=array())
	{
		$this->attributes = array_merge(array('class' => array()), $attributes);
	}


	/**
	 * @param $name
	 * @param $value
	 * @return $this
	 */
	public function set($name, $value)
	{
		$this->attributes[$name] = $value;

		return $this;
	}


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function get($name, $default=null)
	{
		if($this->has($name)) {
			return $this->attributes[$name];
		}

		return $default;
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function has($name)
	{
		return isset($this->attributes[$name]);
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function remove($name)
	{
		unset($this->attributes[$name]);

		return $this;
	}


	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function add(array $attributes)
	{
		foreach($attributes as $name => $value) {
			$this->set($name, $value);
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
			switch($name) {
				case 'compact':
				case 'declare':
				case 'defer':
				case 'disabled':
				case 'ismap':
				case 'readonly':
				case 'required':
				case 'selected':
				case 'multiple':
				case 'nowrap':
					if($value) {
						$buffer .= ' ' . $name;
					}

					break;

				case 'class':
					if(!empty($value)) {
						$value = array_map('specialchars', $value);
						$value = implode(' ', $value);

						$buffer .= sprintf($template, $name, $value);
					}

					break;

				default:
					if(!is_array($value)) {
						$buffer .= sprintf($template, $name, specialchars($value));
					}

					break;
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
		return $this->has($offset);
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
		return $this->get($offset);
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
		$this->set($offset, $value);
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
		$this->remove($offset);
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

}