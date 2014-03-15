<?php

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