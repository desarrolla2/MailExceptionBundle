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

class ValueExporterExtension extends \Twig_Extension
{
    /**
     * @param $vars
     * @return string
     */
    public function dump($vars)
    {
        ob_start();
        echo sprintf('<pre>%s</pre>', print_r($vars, true));

        return ob_get_clean();
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'value_dump',
                [$this, 'dump'],
                [
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }
}
