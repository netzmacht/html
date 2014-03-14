<?php

namespace Netzmacht\Html;

use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\Standalone;
use Netzmacht\Html\Factory\FactoryInterface;
use Netzmacht\Html\Factory\SimpleFactory;


/**
 * Class Node
 * @package Netzmacht\FormHelper\Html
 */
abstract class Element implements GenerateInterface
{
	/**
	 * @var string
	 */
	protected $tag;

	/**
	 * @var FactoryInterface
	 */
	protected static $factory;

	/**
	 * @var Attributes
	 */
	protected $attributes;


	/**
	 * @param string $tag
	 * @param array $attributes
	 */
	function __construct($tag, $attributes=array())
	{
		$attributes       = array_merge(array('class' => array()), $attributes);
		$this->attributes = new Attributes($attributes);
		$this->tag        = $tag;
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


	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}


	/**
	 * @param $tag
	 * @param array $attributes
	 * @return Standalone|Node
	 */
	public static function create($tag, array $attributes=array())
	{
		static::getFactory()->createElement($tag, $attributes);
	}


	/**
	 * @param Node $parent
	 * @param string $position
	 * @return $this
	 */
	public function appendTo(Node $parent, $position=Node::POSITION_LAST)
	{
		$parent->addChild($this, $position);

		return $this;
	}


	/**
	 * @return string
	 */
	abstract public function generate();


	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}


	/**
	 * @param \Netzmacht\Html\Factory\FactoryInterface $factory
	 */
	public static function setFactory(FactoryInterface $factory)
	{
		self::$factory = $factory;
	}


	/**
	 * @return \Netzmacht\Html\Factory\FactoryInterface
	 */
	public static function getFactory()
	{
		if(self::$factory === null) {
			self::$factory = new SimpleFactory();
		}

		return self::$factory;
	}

} 