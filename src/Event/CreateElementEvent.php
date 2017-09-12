<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Event;

use Netzmacht\Html\Element;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CreateElementEvent
 *
 * @package Netzmacht\Html\Event
 */
class CreateElementEvent extends Event
{
    const NAME = 'netzmacht.html.create-element';

    /**
     * Tag name.
     *
     * @var string
     */
    protected $tag;

    /**
     * Attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Created element.
     *
     * @var Element
     */
    protected $element;

    /**
     * Construct.
     *
     * @param string $tag        Tag name.
     * @param array  $attributes List of attributes.
     */
    public function __construct($tag, array $attributes = [])
    {
        $this->tag        = $tag;
        $this->attributes = $attributes;
    }

    /**
     * Get all attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
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
     * Set the element.
     *
     * @param \Netzmacht\Html\Element $element
     */
    public function setElement(Element $element)
    {
        $this->element = $element;
    }

    /**
     * Get the element.
     *
     * @return \Netzmacht\Html\Element
     */
    public function getElement()
    {
        return $this->element;
    }
}
