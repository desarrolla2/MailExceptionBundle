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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * MailExceptionExtension
 */
class MailExceptionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('exception_listener.from', $config['from']);
        $container->setParameter('exception_listener.to', $config['to']);
        $container->setParameter('exception_listener.subject', $config['subject']);
        if (isset($config['avoid'])) {
            $container->setParameter('exception_listener.avoid.environments', $config['avoid']['environments']);
            $container->setParameter('exception_listener.avoid.exceptions', $config['avoid']['exceptions']);
        } else {
            $container->setParameter('exception_listener.avoid.environments', array());
            $container->setParameter('exception_listener.avoid.exceptions', array());
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('listeners.xml');
        $loader->load('services.xml');
    }
}
