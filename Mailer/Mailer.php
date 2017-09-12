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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
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
    protected $tokenStorage;

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
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param TwigEngine $twig
     * @param RequestStack $stack
     * @param TokenStorage|null $tokenStorage
     * @param SessionInterface $session
     * @param $from
     * @param $to
     * @param $subject
     */
    public function __construct(
        \Swift_Mailer $mailer,
        TwigEngine $twig,
        RequestStack $stack,
        TokenStorage $tokenStorage = null,
        SessionInterface $session,
        $from,
        $to,
        $subject
    ) {

        if ($stack) {
            $this->request = $stack->getCurrentRequest();
        }
        $this->mailer = $mailer;
        $this->twigEngine = $twig;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;

        ldd($this->getUser());
    }

    /**
     * @param \Exception $exception
     * @param array $extra
     *
     * @return int
     */
    public function notify(\Exception $exception, array $extra = [])
    {
        $message = $this
            ->createMessage()
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setSubject(sprintf('%s [%s]', $this->subject, $exception->getMessage()))
            ->setBody($this->getBody($exception, $extra), 'text/html');

        return $this->mailer->send($message);
    }

    /**
     * @return \Swift_Mime_SimpleMessage
     */
    protected function createMessage()
    {
        return \Swift_Message::newInstance();
    }

    /**
     * @param \Exception $exception
     * @param array $extra
     *
     * @return string
     */
    protected function getBody(\Exception $exception, array $extra = [])
    {
        if (!count($extra)) {
            $extra = false;
        }
        $session = $this->session ? $this->session->all() : [];
        if (array_key_exists('_security_main', $session)) {
            unset($session['_security_main']);
        }
        $headers = $get = $post = [];
        if ($this->request) {
            if ($this->request->headers) {
                $headers = $this->request->headers->all();
                $get = $this->request->query ? $this->request->query->all() : [];
                $post = $this->request->request ? $this->request->request->all() : [];
            }
        }
        ksort($headers);
        ksort($session);
        ksort($get);
        ksort($post);

        $parameters = [
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'ip' => $this->request ? $this->request->getClientIp() : false,
            'trace' => preg_split('/\r\n|\r|\n/', $exception->getTraceAsString()),
            'extra' => $extra,
            'user' => false,
            'path' => false,
            'host' => false,
            'headers' => $headers,
            'session' => false,
            'get' => false,
            'post' => false,
        ];

        if (!$this->request) {
            return $this->twigEngine->render('MailExceptionBundle:Mail:exception.html.twig', $parameters);
        }


        return $this->twigEngine->render(
            'MailExceptionBundle:Mail:exception.html.twig',
            array_merge(
                $parameters,
                [
                    'path' => $this->request ? $this->request->getRequestUri() : '',
                    'host' => $this->request ? $this->request->getSchemeAndHttpHost() : '',
                    'user' => $this->getUser(),
                    'session' => $session,
                    'get' => $get,
                    'post' => $post,
                ]
            )
        );
    }

    /**
     * @return string|void
     */
    protected function getUser()
    {
        if (!$this->tokenStorage) {
            return;
        }
        if (null === $token = $this->tokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }
        
        if (method_exists($user, 'getId') && method_exists($user, 'getEmail') && method_exists($user, 'getName')) {
            return sprintf('[%d] %s <%s>', $user->getId(), $user->getName(), $user->getEmail());
        }

        return (string)$user;
    }
}
