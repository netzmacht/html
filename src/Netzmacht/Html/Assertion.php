<?php

/**
 * @package    html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 */

namespace Netzmacht\Html;


class Assertion extends \Assert\Assertion
{
	/**
	 * @var string
	 */
	protected static $exceptionClass = 'Netzmacht\Html\Exception\InvalidArgumentException';

} 