<?php

declare(strict_types=1);

/**
 * Simple HTML library.
 *
 * @filesource
 */

namespace Netzmacht\Html;

interface CastsToString
{
    /**
     * Generates the element.
     */
    public function generate(): string;

    /**
     * Cast to string method.
     */
    public function __toString(): string;
}
