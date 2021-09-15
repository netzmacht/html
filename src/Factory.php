<?php

declare(strict_types=1);

/**
 * Simple HTML library.
 *
 * @filesource
 */

namespace Netzmacht\Html;

interface Factory
{
    /**
     * Create an element.
     *
     * @param string              $tag        Tag name.
     * @param array<string,mixed> $attributes Array of attributes.
     */
    public function create(string $tag, array $attributes = []): Element;
}
