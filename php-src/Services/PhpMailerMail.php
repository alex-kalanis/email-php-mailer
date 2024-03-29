<?php

namespace kalanis\EmailPhpMailer\Services;


use PHPMailer\PHPMailer as Mailer;


/**
 * Class PhpMailerMail
 * Make and send each mail via PHPMailer
 */
class PhpMailerMail extends PhpMailer
{
    public function __construct()
    {
        $mailer = new Mailer\PHPMailer(true);
        // Server settings
        $mailer->isMail(); // Send using simple Mail

        parent::__construct($mailer);
    }

    public function systemServiceId(): int
    {
        return 2;
    }
}
