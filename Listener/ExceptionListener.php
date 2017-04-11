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

namespace Desarrolla2\Bundle\MailExceptionBundle\Listener;

use Desarrolla2\Bundle\MailExceptionBundle\Mailer\Mailer;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * ExceptionListener
 */
class ExceptionListener implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var array
     */
    protected $avoidExceptions;

    /**
     * @var array
     */
    protected $avoidEnvironments;

    /**
     * @param Mailer $mailer
     * @param string $environment
     * @param array  $avoidEnvironments
     * @param array  $avoidExceptions
     */
    public function __construct(Mailer $mailer, $environment = 'dev', $avoidEnvironments = [], $avoidExceptions = [])
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
        $this->avoidEnvironments = $avoidEnvironments;
        $this->avoidExceptions = $avoidExceptions;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$this->isValidEnvironment($this->environment) || !$this->isValidException($exception)) {
            return;
        }

        return $this->mailer->notify($exception);
    }

    /**
     * @param Exception $exception
     *
     * @return bool
     */
    protected function isValidException(\Exception $exception)
    {
        $class = get_class($exception);
        if (in_array($class, $this->avoidExceptions)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $env
     *
     * @return bool
     */
    protected function isValidEnvironment($env)
    {
        if (in_array($env, $this->avoidEnvironments)) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
