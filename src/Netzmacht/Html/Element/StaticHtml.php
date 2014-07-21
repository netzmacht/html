<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Element;


use Netzmacht\Html\CastsToString;

class StaticHtml implements CastsToString
{
	/**
	 * @var string
	 */
	private $html;

	/**
	 * @param $html
	 */
	function __construct($html)
	{
		$this->html = $html;
	}


	/**
	 * @param string $html
	 * @return $this
	 */
	public function setHtml($html)
	{
		$this->html = $html;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getHtml()
	{
		return $this->html;
	}


	/**
	 * Generates the element
	 *
	 * @return string
	 */
	public function generate()
	{
		return $this->getHtml();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->generate();
	}

} 