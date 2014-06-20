<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Factory;
use Netzmacht\Html\Event\CreateElementEvent;
use Netzmacht\Html\Exception\RuntimeException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventBasedFactory implements Factory
{

	/**
	 * @var EventDispatcherInterface
	 */
	protected $eventDispatcher;


	/**
	 * @param EventDispatcherInterface $eventDispatcher
	 */
	function __construct(EventDispatcherInterface $eventDispatcher)
	{
		$this->eventDispatcher = $eventDispatcher;
	}


	/**
	 * @param string $tag
	 * @param array $attributes
	 * @throws RuntimeException
	 * @return \Netzmacht\Html\Element
	 */
	public function createElement($tag, array $attributes=array())
	{
		$event = new CreateElementEvent($tag, $attributes);
		$this->eventDispatcher->dispatch(CreateElementEvent::NAME, $event);
		$element = $event->getElement();

		if(!$element) {
			throw new RuntimeException('No element created by dispatcher');
		}

		return $event->getElement();
	}

}