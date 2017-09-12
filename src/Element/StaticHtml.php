<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

declare(strict_types=1);

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
    public function __construct(string $html)
    {
        $this->html = $html;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): string
    {
        return $this->html;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->generate();
    }
}
