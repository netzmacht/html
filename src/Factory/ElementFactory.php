<?php

declare(strict_types=1);

namespace Netzmacht\Html\Factory;

use Netzmacht\Html\Element;
use Netzmacht\Html\Element\Node;
use Netzmacht\Html\Element\StandaloneElement;
use Netzmacht\Html\Factory;

use function in_array;

class ElementFactory implements Factory
{
    /**
     * All standalone elements.
     *
     * @var list<string>
     */
    private $standalone = [
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
     * @param list<string>|null $standalone Override the standalone elements.
     */
    public function __construct(?array $standalone = null)
    {
        if (! $standalone) {
            return;
        }

        $this->standalone = $standalone;
    }

    /**
     * Create an element.
     *
     * @param string              $tag        Tag name.
     * @param array<string,mixed> $attributes Array of attributes.
     */
    public function create(string $tag, array $attributes = []): Element
    {
        if (in_array($tag, $this->standalone)) {
            return new StandaloneElement($tag, $attributes);
        }

        return new Node($tag, $attributes);
    }
}
