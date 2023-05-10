<?php

declare(strict_types=1);

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Element;

use function array_search;
use function array_unshift;
use function array_values;
use function sprintf;

use const PHP_EOL;

/**
 * A Node can contain children.
 */
class Node extends AbstractElement
{
    public const POSITION_FIRST = 'first';
    public const POSITION_LAST  = 'last';

    /**
     * List of children.
     *
     * @var list<Element>
     */
    protected array $children = [];

    /**
     * Add a child.
     *
     * @param Element|string $child    Child content.
     * @param string         $position Position of the child.
     *
     * @return $this
     */
    public function addChild(Element|string $child, string $position = self::POSITION_LAST): self
    {
        if (! $child instanceof Element) {
            $child = new StaticElement($child);
        }

        if ($position === self::POSITION_FIRST) {
            array_unshift($this->children, $child);
        } else {
            $this->children[] = $child;
        }

        return $this;
    }

    /**
     * Add a list of children.
     *
     * @param list<Element|string> $children List of children.
     *
     * @return $this
     */
    public function addChildren(array $children): self
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Remove a child.
     *
     * @param Element $child Child to remove.
     *
     * @return $this
     */
    public function removeChild(Element $child): self
    {
        $key = array_search($child, $this->children, true);

        if ($key !== false) {
            unset($this->children[$key]);
            $this->children = array_values($this->children);
        }

        return $this;
    }

    /**
     * Remove all children.
     *
     * @return $this
     */
    public function removeChildren(): self
    {
        $this->children = [];

        return $this;
    }

    /**
     * Get the list of children.
     *
     * @return list<Element>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Get child content.
     */
    public function getContent(): string
    {
        return $this->generateChildren();
    }

    public function generate(): string
    {
        return sprintf(
            '<%s %s>%s</%s>' . PHP_EOL,
            $this->getTag(),
            $this->generateAttributes(),
            $this->generateChildren(),
            $this->getTag(),
        );
    }

    /**
     * Generate all children.
     */
    private function generateChildren(): string
    {
        $buffer = '';

        foreach ($this->children as $child) {
            $buffer .= $child->generate();
        }

        return $buffer;
    }
}
