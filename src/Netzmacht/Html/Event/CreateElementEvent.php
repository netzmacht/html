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

use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\Event;

class CreateElementEvent extends Event
{
	const NAME = 'netzmacht.html.create-element';

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
	 * @param string $tag
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
	 * @param \Netzmacht\Html\Element $element
	 */
	public function setElement(Element $element)
	{
		$this->element = $element;
	}


	/**
	 * @return \Netzmacht\Html\Element
	 */
	public function getElement()
	{
		return $this->element;
	}

} 