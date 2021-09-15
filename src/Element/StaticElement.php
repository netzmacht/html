<?php

declare(strict_types=1);

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Element;

class StaticElement implements Element
{
    /**
     * Element content.
     *
     * @var string
     */
    private $content;

    /**
     * Construct.
     *
     * @param string $content Element content.
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function generate(): string
    {
        return $this->content;
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}
