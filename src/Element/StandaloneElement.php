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

/**
 * Standalone elements does not have an closing tag
 *
 * @package Netzmacht\Html\Element
 */
class StandaloneElement extends AbstractElement
{
    /**
     * {@inheritdoc}
     */
    public function generate(): string
    {
        return sprintf(
            '<%s %s>' . PHP_EOL,
            $this->tag,
            $this->generateAttributes()
        );
    }
}
