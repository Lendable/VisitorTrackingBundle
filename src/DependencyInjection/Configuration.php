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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('alpha_visitor_tracking');

        \assert($rootNode instanceof ArrayNodeDefinition);
        $rootNode->append($this->createSubscriberNode());

        return $treeBuilder;
    }

    private function createSubscriberNode(): ArrayNodeDefinition
    {
        $root = (new TreeBuilder())->root('session_subscriber');
        \assert($root instanceof ArrayNodeDefinition);
        $root->addDefaultsIfNotSet();

        $root->children()->arrayNode('firewall_blacklist')
            ->defaultValue([])
            ->prototype('scalar')
            ->cannotBeEmpty();

        return $root;
    }
}
