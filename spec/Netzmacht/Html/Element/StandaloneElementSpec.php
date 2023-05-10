<?php

declare(strict_types=1);

namespace spec\Netzmacht\Html\Element;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StandaloneElement;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use const PHP_EOL;

final class StandaloneElementSpec extends ObjectBehavior
{
    /** @var array{class: list<string>, src: string} */
    private array $attributes = ['class' => ['example'], 'src' => 'file.png'];

    public function let(): void
    {
        $this->beConstructedWith('img', $this->attributes);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Element::class);
        $this->shouldHaveType(StandaloneElement::class);
    }

    public function it_has_attributes(): void
    {
        $this->shouldHaveType(Attributes::class);
    }

    public function it_generates_attribute(): void
    {
        $this->generateAttributes()->shouldReturn('class="example" src="file.png"');
    }

    public function it_has_a_tag(): void
    {
        $this->getTag()->shouldReturn('img');
    }

    public function it_casts_to_string(): void
    {
        $this->generate()->shouldReturn('<img class="example" src="file.png">' . PHP_EOL);
    }

    public function it_is_appendable(Node $parent): void
    {
        $parent->addChild($this, Argument::any())->shouldBeCalled();

        $this->appendTo($parent)->shouldReturn($this);
    }

    public function it_is_appendable_to_position(Node $parent): void
    {
        $parent->addChild($this, Node::POSITION_FIRST)->shouldBeCalled();

        $this->appendTo($parent, Node::POSITION_FIRST)->shouldReturn($this);
    }
}
