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
 * Class CastsToString.
 *
 * @package Netzmacht\Html
 */
interface CastsToString
{
    /**
     * Generates the element.
     *
     * @return string
     */
    public function generate();

    /**
     * Cast to string method.
     *
     * @return string
     */
    public function __toString();
}
