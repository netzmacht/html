<?php

declare(strict_types=1);

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Element;

final class StaticElement implements Element
{
    /**
     * Construct.
     *
     * @param string $content Element content.
     */
    public function __construct(private readonly string $content)
    {
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
