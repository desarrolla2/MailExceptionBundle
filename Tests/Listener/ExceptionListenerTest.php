<?php

/*
 * This file is part of the lapera package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\MailExceptionBundle\Tests\Listener;

use Desarrolla2\Bundle\MailExceptionBundle\Listener\ExceptionListener;
use Desarrolla2\Bundle\MailExceptionBundle\Mailer\Mailer;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * ExceptionListenerTest
 */
class ExceptionListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelException()
    {
        $listener = new ExceptionListener($this->getMailer());
        $listener->onKernelException($this->getGetResponseForExceptionEvent());
    }

    protected function getMailer()
    {
        $mailer = $this->getMockBuilder('Desarrolla2\Bundle\MailExceptionBundle\Mailer\Mailer')
            ->disableOriginalConstructor()
            ->getMock();

        $mailer->expects($this->once())
            ->method('notify')
            ->will($this->returnValue(1));

        return $mailer;
    }

    protected function getGetResponseForExceptionEvent()
    {
        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->once())
            ->method('getException')
            ->will($this->returnValue(new \Exception()));

        return $event;
    }
}