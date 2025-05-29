<?php

namespace SortedLinkedList\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sorted_linked_list');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()->scalarNode('default')->defaultValue('SortedLinkedList\\Model\\SkipList\\SkipList')->end()->end();

        return $treeBuilder;
    }
}