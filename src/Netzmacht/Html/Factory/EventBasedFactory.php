<?php

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Event\CreateElementEvent;
use Netzmacht\Html\Event\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventBasedFactory
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
	 * @param $tag
	 * @param array $attributes
	 * @return \Netzmacht\Html\Element
	 */
	public function createElement($tag, array $attributes=array())
	{
		$event = new CreateElementEvent($tag, $attributes);
		$this->eventDispatcher->dispatch(Events::CREATE_ELEMENT, $event);

		return $event->getElement();
	}

}