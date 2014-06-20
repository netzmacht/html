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

use Netzmacht\Html\Element;

/**
 * Interface FactoryInterface
 * @package Netzmacht\Html\Factory
 */
interface Factory
{

	/**
	 * @param string $tag
	 * @param array $attributes
	 * @return Element
	 */
	public function createElement($tag, array $attributes=array());

} 