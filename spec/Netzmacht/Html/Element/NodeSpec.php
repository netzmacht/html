<?php

declare(strict_types=1);

namespace spec\Netzmacht\Html\Element;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element\AbstractElement;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StaticElement;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use const PHP_EOL;

final class NodeSpec extends ObjectBehavior
{
    /** @var array{class: list<string>, src: string} */
    private array $attributes = ['class' => ['example'], 'id' => 'test'];

    public function let(): void
    {
        $this->beConstructedWith('p', $this->attributes);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AbstractElement::class);
        $this->shouldHaveType(Node::class);
    }

    public function it_has_attributes(): void
    {
        $this->shouldHaveType(Attributes::class);
    }

    public function it_generates_attribute(): void
    {
        $this->generateAttributes()->shouldReturn('class="example" id="test"');
    }

    public function it_casts_to_string(): void
    {
        $this->generate()->shouldReturn('<p class="example" id="test"></p>' . PHP_EOL);
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

    public function it_adds_child(Node $child): void
    {
        $this->addChild($child)->shouldReturn($this);
        $this->getChildren()->shouldReturn([$child]);
    }

    public function it_adds_childen(Node $child, Node $childB): void
    {
        $children = [$child, $childB];

        $this->addChildren($children)->shouldReturn($this);
        $this->getChildren()->shouldReturn($children);
    }

    public function it_gets_children(Node $a): void
    {
        $this->addChild($a);

        $this->getChildren()->shouldReturn([$a]);
    }

    public function it_removes_child(Node $a): void
    {
        $this->addChild($a);
        $this->getChildren()->shouldReturn([$a]);

        $this->removeChild($a);
        $this->getChildren()->shouldReturn([]);
    }

    public function it_removes_all_children(Node $a): void
    {
        $this->addChild($a);
        $this->getChildren()->shouldReturn([$a]);

        $this->removeChildren()->shouldReturn($this);
        $this->getChildren()->shouldReturn([]);
    }

    public function it_renders_content(Node $a): void
    {
        $content = '<a href="#test">Test</a>';
        $a->generate()->willReturn($content);
        $a->__toString()->willReturn($content);

        $this->getContent()->shouldBe('');

        $this->addChild($a);
        $this->getContent()->shouldBe($content);
    }

    public function it_casts_to_string_contains_content(Node $a): void
    {
        $content = '<a href="#test">Test</a>';
        $a->generate()->willReturn($content);
        $a->__toString()->willReturn($content);

        $this->addChild($a);
        $this->generate()->shouldReturn('<p class="example" id="test">' . $content . '</p>' . PHP_EOL);
    }

    public function it_creates_static_element_for_scalar_content(): void
    {
        $this->addChild('test');
        $this->getChildren()[0]->shouldHaveType(StaticElement::class);
        $this->getChildren()[0]->__toString()->shouldReturn('test');
    }
}
