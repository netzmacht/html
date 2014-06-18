<?php

namespace Netzmacht\Html;

use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\Standalone;
use Netzmacht\Html\Factory\Factory;
use Netzmacht\Html\Factory\SimpleFactory;


/**
 * Class Node
 * @package Netzmacht\FormHelper\Html
 */
abstract class Element extends Attributes implements CastsToString
{
	/**
	 * @var Factory
	 */
	protected static $factory;

	/**
	 * @var string
	 */
	protected $tag;

	/**
	 * @param string $tag
	 * @param array $attributes
	 */
	function __construct($tag, $attributes=array())
	{
		parent::__construct($attributes);
		$this->tag  = $tag;
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
		return static::getFactory()->createElement($tag, $attributes);
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
	protected function generateAttributes()
	{
		return parent::generate();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}


	/**
	 * @param \Netzmacht\Html\Factory\Factory $factory
	 */
	public static function setFactory(Factory $factory)
	{
		self::$factory = $factory;
	}


	/**
	 * @return \Netzmacht\Html\Factory\Factory
	 */
	public static function getFactory()
	{
		if(self::$factory === null) {
			self::$factory = new SimpleFactory();
		}

		return self::$factory;
	}

} 