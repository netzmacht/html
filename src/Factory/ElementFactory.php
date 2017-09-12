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

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StandaloneElement;
use Netzmacht\Html\Factory;

/**
 * Class SimpleFactory
 *
 * @package Netzmacht\Html\Factory
 */
class ElementFactory implements Factory
{
    /**
     * All standalone elements.
     *
     * @var array
     */
    protected static $standalone = [
        'area',
        'base',
        'basefont',
        'br',
        'col',
        'frame',
        'hr',
        'img',
        'input',
        'isindex',
        'link',
        'meta',
        'param',
    ];

    /**
     * Create an element.
     *
     * @param string $tag        Tag name.
     * @param array  $attributes Array of attributes.
     *
     * @return Element
     */
    public function create(string $tag, array $attributes = []): Element
    {
        if (in_array($tag, static::$standalone)) {
            return new StandaloneElement($tag, $attributes);
        }

        return new Node($tag, $attributes);
    }

    /**
     * Set standalone tags.
     *
     * @param string[] $standalone List of standalone tags.
     *
     * @return void
     */
    public static function setStandalone(array $standalone)
    {
        self::$standalone = $standalone;
    }

    /**
     * Get list of standalone tags.
     *
     * @return array
     */
    public static function getStandalone()
    {
        return self::$standalone;
    }
}
