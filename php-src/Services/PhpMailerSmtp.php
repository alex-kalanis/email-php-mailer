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
        $this->mailer = new Mailer\PHPMailer(true);
        $this->mailer->Sender = $sender;
        // Server settings
        $this->mailer->SMTPDebug = Mailer\SMTP::DEBUG_OFF;                 // Enable verbose debug output
        $this->mailer->isSMTP();                                           // Send using SMTP
        $this->mailer->Host       = $host;                                 // Set the SMTP server to send through
        $this->mailer->Port       = $port;                                 // TCP port to connect to
        $this->mailer->SMTPAuth   = true;                                  // Enable SMTP authentication
        $this->mailer->Username   = $user;                                 // SMTP username
        $this->mailer->Password   = $secret;                               // SMTP password
        $this->mailer->SMTPSecure = Mailer\PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    }

    public function systemServiceId(): int
    {
        return 3;
    }
}
