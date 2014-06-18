<?php

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