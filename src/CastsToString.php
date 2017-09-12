<?php

/**
 * Simple HTML library.
 *
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
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
    public function generate(): string;

    /**
     * Cast to string method.
     *
     * @return string
     */
    public function __toString(): string;
}
