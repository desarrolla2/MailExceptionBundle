<?php

/*
 * This file is part of the MailExceptionBundle package.
 *
 * Copyright (c) Daniel González
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\MailExceptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mail_exception');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('from')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('to')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('subject')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('avoid')
                    ->treatNullLike(array())
                    ->children()
                        ->arrayNode('environments')
                            ->treatNullLike(array())
                            ->prototype('scalar')
                            ->end()
                        ->end()
                        ->arrayNode('exceptions')
                            ->treatNullLike(array())
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
