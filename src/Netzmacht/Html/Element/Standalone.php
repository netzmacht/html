<?php

namespace Netzmacht\Html\Element;


use Netzmacht\Html\Element;

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