<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Element;


use Netzmacht\Html\Element;

/**
 * Standalone elements does not have an closing tag
 *
 * @package Netzmacht\Html\Element
 */
class Standalone extends Element
{

	/**
	 * @return string
	 */
	public function generate()
	{
		return sprintf(
			'<%s %s>' . PHP_EOL,
			$this->tag,
			$this->generateAttributes()
		);
	}

}