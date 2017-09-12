<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Element;

use Netzmacht\Html\CastsToString;

/**
 * Class StaticHtml.
 *
 * @package Netzmacht\Html\Element
 */
class StaticHtml implements CastsToString
{
    /**
     * Html content.
     *
     * @var string
     */
    private $html;

    /**
     * Construct.
     *
     * @param string $html Html content.
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * Set the html content.
     *
     * @param string $html Html content.
     *
     * @return $this
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get the html content.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return $this->getHtml();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->generate();
    }
}
