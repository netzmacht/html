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
declare(strict_types=1);

namespace Netzmacht\Html\Element;

use Netzmacht\Html\Element;

/**
 * Class StaticHtml.
 *
 * @package Netzmacht\Html\Element
 */
class StaticElement implements Element
{
    /**
     * Element content.
     *
     * @var string
     */
    private $content;

    /**
     * Construct.
     *
     * @param string $content Element content.
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): string
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->generate();
    }
}
