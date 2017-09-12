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

use Netzmacht\Html\Attributes;
use Netzmacht\Html\Element;

/**
 * Class Element.
 *
 * @package Netzmacht\FormHelper\Html
 */
abstract class AbstractElement extends Attributes implements Element
{
    /**
     * Tag name.
     *
     * @var string
     */
    protected $tag;

    /**
     * Construct.
     *
     * @param string $tag        Tag name.
     * @param array  $attributes List of attributes.
     */
    public function __construct(string $tag, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->tag = $tag;
    }

    /**
     * Get the tag.
     *
     * @return string
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
     *
     * @return string
     */
    public function generateAttributes(): string
    {
        return parent::generate();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->generate();
    }
}
