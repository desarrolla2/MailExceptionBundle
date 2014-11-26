<?php

/*
 * This file is part of the MailExceptionBundle package.
 *
 * Copyright (c) Daniel González
 * Copyright (c) Mario Young
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 * @author Mario Young <maye.co@gmail.com>
 */

namespace Desarrolla2\Bundle\MailExceptionBundle\Twig\Extension;

use Symfony\Component\HttpKernel\DataCollector\Util\ValueExporter;

class ValueExporterExtension extends \Twig_Extension
{
    /**
     * @var ValueExporter
     */
    private $valueExporter;

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('value_dump', array($this, 'dumpValue')),
        );
    }

    public function dumpValue($value)
    {
        if (null === $this->valueExporter) {
            $this->valueExporter = new ValueExporter();
        }

        return $this->valueExporter->exportValue($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'value_exporter';
    }
}
