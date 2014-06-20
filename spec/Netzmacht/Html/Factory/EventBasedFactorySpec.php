<?php

namespace spec\Netzmacht\Html\Factory;

use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Event\CreateElementEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventBasedFactorySpec extends ObjectBehavior
{
	function let(EventDispatcherInterface $eventDispatcherInterface)
	{
		$this->beConstructedWith($eventDispatcherInterface);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Html\Factory\EventBasedFactory');
    }

	function it_dispatches_request_to_event_dispatcher(EventDispatcherInterface $eventDispatcherInterface)
	{
		$eventDispatcherInterface
			->dispatch(CreateElementEvent::NAME, Argument::type('Netzmacht\Html\Event\CreateElementEvent'))
			->shouldBeCalled();

		$this
			->shouldThrow('Netzmacht\Html\Exception\RuntimeException')
			->during('createElement', array('p'));
	}

	function it_returns_result_of_event_dispatcher(EventDispatcherInterface $eventDispatcherInterface, CreateElementEvent $event)
	{

		$node = new Node('p');
		$event->getElement()->willReturn($node);

		$eventDispatcherInterface
			->dispatch(
				CreateElementEvent::NAME,
				Argument::type('Netzmacht\Html\Event\CreateElementEvent')
			)
			->will(function($args) use ($node){
				$args[1]->setElement($node);
			});

		$this->createElement('p')->shouldReturn($node);
		$this->createElement('p')->getTag()->shouldBe('p');
	}

}
