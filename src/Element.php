<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html;

use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\Standalone;
use Netzmacht\Html\Factory;
use Netzmacht\Html\Factory\SimpleFactory;

/**
 * Class Element.
 *
 * @package Netzmacht\FormHelper\Html
 */
abstract class Element extends Attributes implements CastsToString
{
    /**
     * Factory.
     *
     * @var \Netzmacht\Html\Factory
     */
    protected static $factory;

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
    public function __construct($tag, $attributes = [])
    {
        parent::__construct($attributes);
        $this->tag = $tag;
    }

    /**
     * Get the tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }


    /**
     * Create an element.
     *
     * @param string $tag        Tag name.
     * @param array  $attributes Attributes.
     *
     * @return Standalone|Node
     */
    public static function create($tag, array $attributes = [])
    {
        return static::getFactory()->createElement($tag, $attributes);
    }

    /**
     * Append element to a parent element.
     *
     * @param Node   $parent   The parent node.
     * @param string $position Position.
     *
     * @return $this
     */
    public function appendTo(Node $parent, $position = Node::POSITION_LAST)
    {
        $parent->addChild($this, $position);

        return $this;
    }

    /**
     * Generate the attributes.
     *
     * @return string
     */
    public function generateAttributes()
    {
        return parent::generate();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->generate();
    }

    /**
     * Set the factory.
     *
     * @param \Netzmacht\Html\Factory $factory Factory.
     *
     * @return void
     */
    public static function setFactory(Factory $factory)
    {
        self::$factory = $factory;
    }

    /**
     * Get the factory.
     *
     * @return \Netzmacht\Html\Factory
     */
    public static function getFactory()
    {
        if (self::$factory === null) {
            self::$factory = new SimpleFactory();
        }

        return self::$factory;
    }
}
