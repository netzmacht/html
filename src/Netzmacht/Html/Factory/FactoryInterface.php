<?php

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Element;

/**
 * Interface FactoryInterface
 * @package Netzmacht\Html\Factory
 */
interface FactoryInterface
{

	/**
	 * @param string $tag
	 * @param array $attributes
	 * @return Element
	 */
	public function createElement($tag, array $attributes=array());

} 