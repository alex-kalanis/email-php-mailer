<?php

namespace kalanis\EmailPhpMailer\Services;


use PHPMailer\PHPMailer as Mailer;


/**
 * Class PhpMailerSmtp
 * Make and send each mail via PHPMailer
 */
class PhpMailerSmtp extends PhpMailer
{
    public function __construct(string $host = 'localhost', int $port = 25, string $user = '', string $secret = '', string $sender = '')
    {
        $mailer = new Mailer\PHPMailer(true);
        $mailer->Sender = $sender;
        // Server settings
        $mailer->SMTPDebug = Mailer\SMTP::DEBUG_OFF;                 // Enable verbose debug output
        $mailer->isSMTP();                                           // Send using SMTP
        $mailer->Host       = $host;                                 // Set the SMTP server to send through
        $mailer->Port       = $port;                                 // TCP port to connect to
        $mailer->SMTPAuth   = true;                                  // Enable SMTP authentication
        $mailer->Username   = $user;                                 // SMTP username
        $mailer->Password   = $secret;                               // SMTP password
        $mailer->SMTPSecure = Mailer\PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted

        parent::__construct($mailer);
    }

    public function systemServiceId(): int
    {
        return 3;
    }
}
