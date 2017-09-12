<?php

/**
 * @package    netzmacht/html
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Factory;
use Netzmacht\Html\Element;

/**
 * Class SimpleFactory
 *
 * @package Netzmacht\Html\Factory
 */
class SimpleFactory implements Factory
{
    /**
     * All standalone elements
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
     * @return Element\Node|Element\Standalone
     */
    public function createElement($tag, array $attributes = [])
    {
        if (in_array($tag, static::$standalone)) {
            return new Element\Standalone($tag, $attributes);
        }

        return new Element\Node($tag, $attributes);
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
