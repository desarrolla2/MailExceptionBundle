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
        $listener = new ExceptionListener($this->getMailerThatExpectsNotify());
        $listener->onKernelException($this->getGetResponseForExceptionEvent());
    }

    public function testOnKernelExceptionValidEnvironment()
    {
        $listener = new ExceptionListener($this->getMailerThatExpectsNotify(), 'env', ['other']);
        $listener->onKernelException($this->getGetResponseForExceptionEvent());
    }

    public function testOnKernelExceptionInvalidEnvironment()
    {
        $listener = new ExceptionListener($this->getMailerThatNotExpectsNotify(), 'env', ['env']);
        $listener->onKernelException($this->getGetResponseForExceptionEvent());
    }

    public function testOnKernelExceptionValidException()
    {
        $listener = new ExceptionListener($this->getMailerThatExpectsNotify(), 'env', [], ['UninterestingException']);
        $listener->onKernelException($this->getGetResponseForExceptionEvent());
    }

    public function testOnKernelExceptionInvalidException()
    {
        $listener = new ExceptionListener($this->getMailerThatNotExpectsNotify(), 'env', [], ['Exception']);
        $listener->onKernelException($this->getGetResponseForExceptionEvent());
    }

    protected function getMailerThatExpectsNotify()
    {
        $mailer = $this->getMockBuilder('Desarrolla2\Bundle\MailExceptionBundle\Mailer\Mailer')
            ->disableOriginalConstructor()
            ->getMock();

        $mailer->expects($this->once())
            ->method('notify')
            ->will($this->returnValue(1));

        return $mailer;
    }

    protected function getMailerThatNotExpectsNotify()
    {
        $mailer = $this->getMockBuilder('Desarrolla2\Bundle\MailExceptionBundle\Mailer\Mailer')
            ->disableOriginalConstructor()
            ->getMock();

        $mailer->expects($this->never())
            ->method('notify');

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
