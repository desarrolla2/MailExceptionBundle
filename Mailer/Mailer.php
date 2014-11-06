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

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var DateTime
     */
    protected $date;

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
     * @var TwigEngine
     */
    protected $twigEngine;

    /**
     * @param \Swift_Mailer $mailer
     * @param TwigEngine    $twig
     * @param $from
     * @param $to
     * @param $subject
     */
    public function __construct(\Swift_Mailer $mailer, TwigEngine $twig, $from, $to, $subject)
    {
        $this->twigEngine = $twig;
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
    }

    /**
     * @param Request    $request
     * @param \Exception $exception
     */
    public function notify(Request $request, \Exception $exception)
    {
        $message = $this->createMessage()
            ->setSubject($this->subject . '(' . $exception->getMessage() . ')')
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody($this->getBody($request, $exception), 'text/html');

        $this->mailer->send($message);
    }

    /**
     * @param  Request    $request
     * @param  \Exception $exception
     * @return string
     */
    protected function getBody(Request $request, \Exception $exception)
    {
        return $this->twigEngine->render(
            'MailExceptionBundle:Mail:exception.html.twig',
            array(
                'class' => get_class($exception),
                'message' => $exception->getMessage(),
                'trace' => preg_split('/\r\n|\r|\n/', $exception->getTraceAsString()),
                'path' => $request->getRequestUri(),
                'get' => $request->query->all(),
                'post' => $request->request->all(),
            )
        );
    }

    /**
     * @return \Swift_Mime_SimpleMessage
     */
    protected function createMessage()
    {
        return $message = \Swift_Message::newInstance();
    }

}
