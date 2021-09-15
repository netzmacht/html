<?php

declare(strict_types=1);

namespace Netzmacht\Html\Infrastructure\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Netzmacht\Html\Infrastructure\SymfonyBundle\NetzmachtHtmlBundle;

/**
 * Contao manager plugin for auto registering the symfony bundle.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [BundleConfig::create(NetzmachtHtmlBundle::class)];
    }
}
