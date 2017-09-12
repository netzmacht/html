<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Element;

/**
 * A Node can contain children.
 *
 * @package Netzmacht\Html\Element
 */
class Node extends Element
{
    const POSITION_FIRST = 'first';
    const POSITION_LAST = 'last';

    /**
     * @var array
     */
    protected $children = [];


    /**
     * Add a child.
     *
     * @param Element|string $child    Child content.
     * @param string         $position Position of the child.
     *
     * @return $this
     */
    public function addChild($child, $position = Node::POSITION_LAST)
    {
        if (is_int($position)) {
            array_splice($this->children, $position, 0, [$child]);
        } elseif ($position == static::POSITION_FIRST) {
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
    public function addChildren(array $children)
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
    public function removeChild(Element $child)
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
    public function removeChildren()
    {
        $this->children = [];

        return $this;
    }

    /**
     * Get the position of a child.
     *
     * @param mixed $child Child.
     *
     * @return int|false
     */
    public function getChildPosition($child)
    {
        return array_search($child, $this->children);
    }

    /**
     * Create a new child.
     *
     * @param string $tag        Tag of the child.
     * @param array  $attributes Attributes.
     * @param string $position   Position of the child.
     *
     * @return Node|Standalone
     */
    public function createChild($tag, $attributes = [], $position = Node::POSITION_LAST)
    {
        $child = Element::create($tag, $attributes);
        $this->addChild($child, $position);

        return $child;
    }

    /**
     * Get the list of children.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get child content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->generateChildren();
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
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
    private function generateChildren()
    {
        $buffer = '';

        foreach ($this->children as $child) {
            $buffer .= (string) $child;
        }

        return $buffer;
    }
}
