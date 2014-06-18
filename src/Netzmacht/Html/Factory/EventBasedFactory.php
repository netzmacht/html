<?php

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Event\CreateElementEvent;
use Netzmacht\Html\Event\Events;
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
		$this->eventDispatcher->dispatch(Events::CREATE_ELEMENT, $event);
		$element = $event->getElement();

		if(!$element) {
			throw new RuntimeException('No element created by dispatcher');
		}

		return $event->getElement();
	}

}