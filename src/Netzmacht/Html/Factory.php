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

/**
 * Interface FactoryInterface.
 *
 * @package Netzmacht\Html\Factory
 */
interface Factory
{
    /**
     * Create an element.
     *
     * @param string $tag        Tag name.
     * @param array  $attributes Attributes.
     *
     * @return Element
     */
    public function createElement($tag, array $attributes = []);
}
