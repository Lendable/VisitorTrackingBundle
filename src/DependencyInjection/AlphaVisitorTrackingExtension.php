<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AlphaVisitorTrackingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->handleFirewallBlacklist($container, $config);
    }

    private function handleFirewallBlacklist(ContainerBuilder $container, array $config): void
    {
        $subscriber = $container->getDefinition('alpha.visitor_tracking_subscriber');

        $subscriber->replaceArgument(2, $config['session_subscriber']['firewall_blacklist']);
    }
}
