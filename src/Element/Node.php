<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

declare(strict_types=1);

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Element;

/**
 * A Node can contain children.
 *
 * @package Netzmacht\Html\Element
 */
class Node extends AbstractElement
{
    const POSITION_FIRST = 'first';
    const POSITION_LAST = 'last';

    /**
     * List of children.
     *
     * @var array
     */
    protected $children = [];

    /**
     * Add a child.
     *
     * @param Element $child    Child content.
     * @param string  $position Position of the child.
     *
     * @return $this
     */
    public function addChild(Element $child, string $position = Node::POSITION_LAST): self
    {
        if ($position == static::POSITION_FIRST) {
            array_unshift($this->children, $child);
        } else {
            $this->children[] = $child;
        }

        return $this;
    }

    /**
     * Add a list of children.
     *
     * @param array $children List of children.
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
     * @param AbstractElement $child Child to remove.
     *
     * @return $this
     */
    public function removeChild(AbstractElement $child): self
    {
        $key = array_search($child, $this->children);

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
     * @return Element[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Get child content.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->generateChildren();
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): string
    {
        return sprintf(
            '<%s %s>%s</%s>' . PHP_EOL,
            $this->tag,
            $this->generateAttributes(),
            $this->generateChildren(),
            $this->tag
        );
    }

    /**
     * Generate all children.
     *
     * @return string
     */
    private function generateChildren(): string
    {
        $buffer = '';

        foreach ($this->children as $child) {
            $buffer .= (string) $child;
        }

        return $buffer;
    }
}
