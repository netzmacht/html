<?php

namespace Netzmacht\Html\Event;

use Netzmacht\FormHelper\Html\Element;
use Symfony\Component\EventDispatcher\Event;

class CreateElementEvent extends Event
{

	/**
	 * @var string
	 */
	protected $tag;

	/**
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * @var Element
	 */
	protected $element;


	/**
	 * @param $tag
	 * @param array $attributes
	 */
	function __construct($tag, array $attributes=array())
	{
		$this->tag        = $tag;
		$this->attributes = $attributes;
	}


	/**
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}


	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
	}


	/**
	 * @param \Netzmacht\FormHelper\Html\Element $element
	 */
	public function setElement(Element $element)
	{
		$this->element = $element;
	}


	/**
	 * @return \Netzmacht\FormHelper\Html\Element
	 */
	public function getElement()
	{
		return $this->element;
	}

} 