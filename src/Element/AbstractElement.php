<?php

declare(strict_types=1);

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element;

abstract class AbstractElement extends Attributes implements Element
{
    /**
     * Tag name.
     *
     * @var string
     */
    protected $tag;

    /**
     * @param string              $tag        Tag name.
     * @param array<string,mixed> $attributes List of attributes.
     */
    public function __construct(string $tag, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->tag = $tag;
    }

    /**
     * Get the tag.
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * Append element to a parent element.
     *
     * @param Node   $parent   The parent node.
     * @param string $position Position.
     *
     * @return $this
     */
    public function appendTo(Node $parent, string $position = Node::POSITION_LAST): self
    {
        $parent->addChild($this, $position);

        return $this;
    }

    /**
     * Generate the attributes.
     */
    public function generateAttributes(): string
    {
        return parent::generate();
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}
