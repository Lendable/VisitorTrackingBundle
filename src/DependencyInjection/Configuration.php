<?php

declare(strict_types=1);

namespace Alpha\VisitorTrackingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('alpha_visitor_tracking');
        $rootNode = $treeBuilder->getRootNode();
        \assert($rootNode instanceof ArrayNodeDefinition);

        $rootNode->append($this->createSubscriberNode());

        return $treeBuilder;
    }

    private function createSubscriberNode(): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder('session_subscriber');
        $rootNode = $treeBuilder->getRootNode();
        \assert($rootNode instanceof ArrayNodeDefinition);

        $rootNode->addDefaultsIfNotSet();

        $rootNode->children()->arrayNode('firewall_blacklist')
            ->defaultValue([])
            ->prototype('scalar')
            ->cannotBeEmpty();

        return $rootNode;
    }
}
