<?php

declare(strict_types=1);

namespace spec\Netzmacht\Html\Factory;

use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StandaloneElement;
use Netzmacht\Html\Factory;
use Netzmacht\Html\Factory\ElementFactory;
use PhpSpec\ObjectBehavior;

final class ElementFactorySpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Factory::class);
        $this->shouldHaveType(ElementFactory::class);
    }

    public function it_creates_element_with_tag(): void
    {
        $this->create('p')->shouldHaveType(Element::class);
        $this->create('p')->getTag()->shouldBe('p');
    }

    public function it_accepts_attributes(): void
    {
        $attributes = ['class' => ['bar'], 'id' => 'foo'];
        $this->create('p', $attributes)->getAttributes()->shouldReturn($attributes);
    }

    public function it_creates_node(): void
    {
        $this->create('p')->shouldHaveType(Node::class);
    }

    public function it_creates_standalone(): void
    {
        $this->create('img')->shouldHaveType(StandaloneElement::class);
    }

    public function it_accepts_standalone_config(): void
    {
        $standalone = ['p'];

        $this->beConstructedWith($standalone);
        $this->create('p')->shouldHaveType(StandaloneElement::class);
    }
}
