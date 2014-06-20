<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Event;

use Netzmacht\Html\Attributes;
use Symfony\Component\EventDispatcher\Event;

class AttributesEvent extends Event
{

	/**
	 * @var Attributes
	 */
	protected $attributes;


	/**
	 * @param Attributes $attributes
	 */
	function __construct(Attributes $attributes)
	{
		$this->attributes = $attributes;
	}


	/**
	 * @return \Netzmacht\Html\Attributes
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

} 