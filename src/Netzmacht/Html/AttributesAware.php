<?php

namespace Netzmacht\Html;


class AttributesAware
{

	/**
	 * @var Attributes
	 */
	protected $attributes;


	/**
	 * @param array $attributes
	 */
	function __construct($attributes=array())
	{
		$attributes       = array_merge(array('class' => array()), $attributes);
		$this->attributes = new Attributes($attributes);
	}


	/**
	 * @param array $attributes
	 * @return $this
	 */
	public function setAttributes($attributes)
	{
		$this->attributes->add($attributes);
		return $this;
	}


	/**
	 * @return Attributes
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}


	/**
	 * @param $name
	 * @param $value
	 * @return $this
	 */
	public function setAttribute($name, $value)
	{
		$this->attributes->set($name, $value);

		return $this;
	}


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAttribute($name, $default=null)
	{
		return $this->attributes->get($name, $default);
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function hasAttribute($name)
	{
		return $this->attributes->has($name);
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function removeAttribute($name)
	{
		$this->attributes->remove($name);

		return $this;
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
	 * @param $name
	 * @return $this
	 */
	public function addClass($name)
	{
		if(!$this->hasClass($name)) {
			$classes = $this->getAttribute('class');
			$classes[] = $name;

			$this->setAttribute('class', $classes);
		}

		return $this;
	}


	/**
	 * @param $name
	 * @return $this
	 */
	public function removeClass($name)
	{
		if($this->hasClass($name)) {
			$classes = $this->getAttribute('class');
			$index = array_search($name, $classes);
			unset($classes[$index]);

			$this->setAttribute('class', array_values($classes));
		}

		return $this;
	}


	/**
	 * @param $value
	 * @return $this
	 */
	public function setId($value)
	{
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

} 