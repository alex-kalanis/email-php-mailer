# Email Api - PHP Mailer 

![Build Status](https://github.com/alex-kalanis/email-php-mailer/actions/workflows/code_checks.yml/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/email-php-mailer/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/email-php-mailer)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/email-php-mailer.svg?v1)](https://packagist.org/packages/alex-kalanis/email-php-mailer)
[![License](https://poser.pugx.org/alex-kalanis/email-php-mailer/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/email-php-mailer)

Sending emails - via classical PHP Mailer 

Contains libraries for sending emails via PHPMailer - set it yourself 

# PHP Installation

```bash
composer.phar require alex-kalanis/email-php-mailer
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add selected services into the "\kalanis\EmailApi\LocalInfo\ServicesOrdering" constructor. Beware additional necessary params and classes for your use case.

3.) Add Ordering and your implementation of "\kalanis\EmailApi\Interfaces\ILocalProcessing" into your "\kalanis\EmailApi\Sending".

4.) Just call sending as described in the "\kalanis\EmailApi\Sending".
