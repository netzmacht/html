<?php

declare(strict_types=1);

namespace Netzmacht\Html\Element;

use function sprintf;

use const PHP_EOL;

/**
 * Standalone elements does not have an closing tag
 */
final class StandaloneElement extends AbstractElement
{
    public function generate(): string
    {
        return sprintf(
            '<%s %s>' . PHP_EOL,
            $this->getTag(),
            $this->generateAttributes(),
        );
    }
}
