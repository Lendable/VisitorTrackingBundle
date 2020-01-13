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
        if ($this->isBeforeSymfony4()) {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('alpha_visitor_tracking');
        } else {
            $treeBuilder = new TreeBuilder('alpha_visitor_tracking');
            $rootNode = $treeBuilder->getRootNode();
        }
        \assert($rootNode instanceof ArrayNodeDefinition);

        $rootNode->append($this->createSubscriberNode());

        return $treeBuilder;
    }

    private function createSubscriberNode(): ArrayNodeDefinition
    {
        if ($this->isBeforeSymfony4()) {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('session_subscriber');
        } else {
            $treeBuilder = new TreeBuilder('session_subscriber');
            $rootNode = $treeBuilder->getRootNode();
        }
        \assert($rootNode instanceof ArrayNodeDefinition);

        $rootNode->addDefaultsIfNotSet();

        $rootNode->children()->arrayNode('firewall_blacklist')
            ->defaultValue([])
            ->prototype('scalar')
            ->cannotBeEmpty();

        return $rootNode;
    }

    private function isBeforeSymfony4(): bool
    {
        return !\method_exists(TreeBuilder::class, 'getRootNode');
    }
}
