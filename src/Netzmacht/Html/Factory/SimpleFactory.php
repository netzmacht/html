<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Factory;
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
	 * @param string[] $standalone
	 */
	public static function setStandalone(array $standalone)
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