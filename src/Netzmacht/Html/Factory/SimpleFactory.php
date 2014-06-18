<?php

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Element;

class SimpleFactory implements Factory
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
		'param'
	);


	/**
	 * @param string $tag
	 * @param array $attributes
	 * @return Element\Node|Element\Standalone
	 */
	public function createElement($tag, array $attributes = array())
	{
		if(in_array($tag, static::$standalone)) {
			return new Element\Standalone($tag, $attributes);
		}

		return new Element\Node($tag, $attributes);
	}


	/**
	 * @param array $standalone
	 */
	public static function setStandalone($standalone)
	{
		self::$standalone = $standalone;
	}


	/**
	 * @return array
	 */
	public static function getStandalone()
	{
		return self::$standalone;
	}

} 