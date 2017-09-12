<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace spec\Netzmacht\Html\Element;

use Netzmacht\Html\Element\Node;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeSpec extends ObjectBehavior
{
    private $attributes = ['class' => ['example'], 'id' => 'test'];

    function let()
    {
        $this->beConstructedWith('p', $this->attributes);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Netzmacht\Html\Element\AbstractElement');
        $this->shouldHaveType('Netzmacht\Html\Element\Node');
    }

    function it_has_attributes()
    {
        $this->shouldHaveType('Netzmacht\Html\Attributes');
    }

    function it_generates_attribute()
    {
        $this->generateAttributes()->shouldReturn('class="example" id="test"');
    }

    function it_casts_to_string()
    {
        $this->generate()->shouldReturn('<p class="example" id="test"></p>' . PHP_EOL);
    }

    function it_is_appendable(Node $parent)
    {
        $parent->addChild($this, Argument::any())->shouldBeCalled();

        $this->appendTo($parent)->shouldReturn($this);
    }

    function it_is_appendable_to_position(Node $parent)
    {
        $parent->addChild($this, Node::POSITION_FIRST)->shouldBeCalled();

        $this->appendTo($parent, Node::POSITION_FIRST)->shouldReturn($this);
    }

    function it_adds_child(Node $child)
    {
        $this->addChild($child)->shouldReturn($this);
        $this->getChildren()->shouldReturn([$child]);
    }

    function it_adds_childen(Node $child, Node $childB)
    {
        $children = [$child, $childB];

        $this->addChildren($children)->shouldReturn($this);
        $this->getChildren()->shouldReturn($children);
    }

    function it_gets_children(Node $a)
    {
        $this->addChild($a);

        $this->getChildren()->shouldReturn([$a]);
    }

    function it_removes_child(Node $a)
    {
        $this->addChild($a);
        $this->getChildren()->shouldReturn([$a]);

        $this->removeChild($a);
        $this->getChildren()->shouldReturn([]);
    }

    function it_removes_all_children(Node $a)
    {
        $this->addChild($a);
        $this->getChildren()->shouldReturn([$a]);

        $this->removeChildren()->shouldReturn($this);
        $this->getChildren()->shouldReturn([]);
    }

    function it_renders_content(Node $a)
    {
        $content = '<a href="#test">Test</a>';
        $a->generate()->willReturn($content);
        $a->__toString()->willReturn($content);

        $this->getContent()->shouldBe('');

        $this->addChild($a);
        $this->getContent()->shouldBe($content);
    }

    function it_casts_to_string_contains_content(Node $a)
    {
        $content = '<a href="#test">Test</a>';
        $a->generate()->willReturn($content);
        $a->__toString()->willReturn($content);

        $this->addChild($a);
        $this->generate()->shouldReturn('<p class="example" id="test">' . $content . '</p>' . PHP_EOL);
    }
}
