<?php

declare(strict_types=1);

namespace Netzmacht\Html\Infrastructure\SymfonyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class NetzmachtHtmlExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        if (! isset($config['standalone']) || ! $container->hasDefinition('netzmacht.html.factory')) {
            return;
        }

        $definition = $container->getDefinition('netzmacht.html.factory');
        $definition->addArgument($config['standalone']);
    }
}
