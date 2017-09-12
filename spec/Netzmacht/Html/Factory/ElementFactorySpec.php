<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace spec\Netzmacht\Html\Factory;

use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StandaloneElement;
use Netzmacht\Html\Factory;
use Netzmacht\Html\Factory\ElementFactory;
use PhpSpec\ObjectBehavior;

class ElementFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Factory::class);
        $this->shouldHaveType(ElementFactory::class);
    }

    function it_creates_element_with_tag()
    {
        $this->create('p')->shouldHaveType(Element::class);
        $this->create('p')->getTag()->shouldBe('p');
    }

    function it_accepts_attributes()
    {
        $attributes = ['class' => ['bar'], 'id' => 'foo'];
        $this->create('p', $attributes)->getAttributes()->shouldReturn($attributes);
    }

    function it_creates_node()
    {
        $this->create('p')->shouldHaveType(Node::class);
    }

    function it_creates_standalone()
    {
        $this->create('img')->shouldHaveType(StandaloneElement::class);
    }

    function it_accepts_standalone_config()
    {
        $standalone = ['p'];

        $this->create('p')->shouldHaveType(Node::class);
        $this->setStandalone($standalone);
        $this->create('p')->shouldHaveType(StandaloneElement::class);
    }

    function it_returns_current_standalone_config()
    {
        $standalone = ['p'];

        $this->setStandalone(['p']);
        $this->getStandalone()->shouldReturn($standalone);
    }

    function it_has_global_standalone_config()
    {
        $standalone = ['p'];

        ElementFactory::setStandalone($standalone);
        $this->getStandalone()->shouldReturn($standalone);
    }
}
