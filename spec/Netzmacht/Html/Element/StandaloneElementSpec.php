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

use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StandaloneElement;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandaloneElementSpec extends ObjectBehavior
{
    private $attributes = ['class' => ['example'], 'src' => 'file.png'];


    function let()
    {
        $this->beConstructedWith('img', $this->attributes);
    }


    function it_is_initializable()
    {
        $this->shouldHaveType(Element::class);
        $this->shouldHaveType(StandaloneElement::class);
    }


    function it_has_attributes()
    {
        $this->shouldHaveType(Attributes::class);
    }

    function it_generates_attribute()
    {
        $this->generateAttributes()->shouldReturn('class="example" src="file.png"');
    }


    function it_has_a_tag()
    {
        $this->getTag()->shouldReturn('img');
    }


    function it_casts_to_string()
    {
        $this->generate()->shouldReturn('<img class="example" src="file.png">' . PHP_EOL);
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
}
