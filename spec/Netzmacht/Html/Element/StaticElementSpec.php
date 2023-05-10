<?php

declare(strict_types=1);

namespace spec\Netzmacht\Html\Element;

use Netzmacht\Html\Element;
use Netzmacht\Html\Element\StaticElement;
use PhpSpec\ObjectBehavior;

final class StaticElementSpec extends ObjectBehavior
{
    private const HTML = '<b>Test</b>';

    public function let(): void
    {
        $this->beConstructedWith(self::HTML);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(StaticElement::class);
    }

    public function it_casts_to_string(): void
    {
        $this->shouldHaveType(Element::class);
        $this->generate()->shouldReturn(self::HTML);
        $this->__toString()->shouldReturn(self::HTML);
    }
}
