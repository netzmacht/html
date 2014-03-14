<?php

namespace Netzmacht\Html\Event;

use Netzmacht\Html\Attributes;

class AttributesEvent
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