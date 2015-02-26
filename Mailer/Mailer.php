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

namespace Desarrolla2\Bundle\MailExceptionBundle\Mailer;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Mailer
 */
class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var TwigEngine
     */
    protected $twigEngine;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var SecurityContext
     */
    protected $context;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @param \Swift_Mailer    $mailer
     * @param TwigEngine       $twig
     * @param RequestStack     $stack
     * @param SecurityContext  $context
     * @param SessionInterface $session
     * @param string           $from
     * @param string           $to
     * @param string           $subject
     */
    public function __construct(
        \Swift_Mailer $mailer,
        TwigEngine $twig,
        RequestStack $stack,
        SecurityContext $context,
        SessionInterface $session,
        $from,
        $to,
        $subject
    )
    {
        $this->mailer = $mailer;
        $this->twigEngine = $twig;
        $this->request = $stack->getCurrentRequest();
        $this->context = $context;
        $this->session = $session;
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
    }

    /**
     * @param \Exception $exception
     *
     * @return int
     */
    public function notify(\Exception $exception)
    {
        $message = $this->createMessage()
            ->setSubject($this->subject.'('.$exception->getMessage().')')
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody($this->getBody($exception), 'text/html');

        return $this->mailer->send($message);
    }

    /**
     * @param  \Exception $exception
     *
     * @return string
     */
    protected function getBody(\Exception $exception)
    {
        return $this->twigEngine->render(
            'MailExceptionBundle:Mail:exception.html.twig',
            [
                'class' => get_class($exception),
                'message' => $exception->getMessage(),
                'trace' => preg_split('/\r\n|\r|\n/', $exception->getTraceAsString()),
                'path' => $this->request->getRequestUri(),
                'user' => $this->getUser(),
                'session' => $this->session->all(),
                'get' => $this->request->query->all(),
                'post' => $this->request->request->all(),
            ]
        );
    }

    /**
     * @return \Swift_Mime_SimpleMessage
     */
    protected function createMessage()
    {
        return \Swift_Message::newInstance();
    }

    /**
     * @return string|void
     */
    protected function getUser()
    {
        if (null === $token = $this->context->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return (string) $user;
    }
}
