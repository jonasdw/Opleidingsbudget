<?php
/**
 * Created by PhpStorm.
 * User: jonas_000
 * Date: 3/07/14
 * Time: 15:28
 */

namespace Tactics\OpleidingsbudgetBundle\Mailer;



class OpleidingsbudgetMailer
{
    private $swiftMailer;

    public function __construct(\Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
    }

    public function sendMail($subject, $recievers, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('info@opleidingsbudget.com')
            ->setTo($recievers)
            ->setBody($body);

        $this->swiftMailer->send($message);
    }
} 