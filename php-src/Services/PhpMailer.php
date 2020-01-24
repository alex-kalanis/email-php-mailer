<?php

namespace EmailPhpMailer\Services;

use EmailApi\Interfaces;
use EmailApi\Basics;
use PHPMailer\PHPMailer as Mailer;

/**
 * Class PhpMailer
 * Make and send each mail via PHPMailer - base for creating mails
 */
abstract class PhpMailer implements Interfaces\Sending
{
    const IS_HTML = true;
    const WORD_WRAP = 50;
    const CHARACTER_SET = "utf-8";

    /** @var Mailer\PHPMailer|null */
    protected $mailer = null;

    public function canUseService(): bool
    {
        return true;
    }

    /**
     * Send mail directly via php - just use classical PHPMailer
     *
     * @param Interfaces\Content $content
     * @param Interfaces\EmailUser $to
     * @param Interfaces\EmailUser $from
     * @param Interfaces\EmailUser $replyTo
     * @param bool $toDisabled
     * @return Basics\Result
     */
    public function sendEmail(Interfaces\Content $content, Interfaces\EmailUser $to, ?Interfaces\EmailUser $from = null, ?Interfaces\EmailUser $replyTo = null, $toDisabled = false): Basics\Result
    {
        try {
            //Recipients
            $this->addSenders($from)
                ->setContent($content)
                ->addTargets([$to])
                ->addReply($replyTo)
                ->addAttachments($content)
                ->send();

            return new Basics\Result(true, [
                'message' => 'Message has been sent'
            ]);
        } catch (Mailer\Exception $e) {
            return new Basics\Result(false, [
                'message' => $e->getMessage(),
                'info' => $this->mailer->ErrorInfo,
            ]);
        }
    }

    /**
     * @param Interfaces\EmailUser|null $from
     * @return $this
     * @throws Mailer\Exception
     */
    protected function addSenders(?Interfaces\EmailUser $from = null)
    {
        if ($from) {
            $this->mailer->setFrom($from->getEmail(), $from->getEmailName());
        }
        return $this;
    }

    protected function setContent(Interfaces\Content $content)
    {
        $this->mailer->Subject = $content->getSubject();
        $this->mailer->Body = $content->getHtmlBody();
        $this->mailer->AltBody = $content->getPlainBody();
        $this->mailer->WordWrap = static::WORD_WRAP;
        $this->mailer->CharSet = static::CHARACTER_SET;
        $this->mailer->isHTML(static::IS_HTML);
        return $this;
    }

    /**
     * @param Interfaces\EmailUser[] $to
     * @return $this
     * @throws Mailer\Exception
     */
    protected function addTargets(array $to)
    {
        foreach ($to as $item) {
            $this->mailer->addAddress($item->getEmail(), $item->getName());
        }
        return $this;
    }

    /**
     * @param Interfaces\EmailUser|null $replyTo
     * @return $this
     * @throws Mailer\Exception
     */
    protected function addReply(?Interfaces\EmailUser $replyTo = null)
    {
        if (!empty($replyTo)) {
            $this->mailer->addReplyTo($replyTo->getEmail(), $replyTo->getEmailName());
        }
        return $this;
    }

    /**
     * @param Interfaces\Content $content
     * @return $this
     * @throws Mailer\Exception
     */
    protected function addAttachments(Interfaces\Content $content)
    {
        foreach ($content->getAttachments() as $attachment) {
            if (Interfaces\ContentAttachment::TYPE_IMAGE == $attachment->getType()) {
                $this->mailer->addEmbeddedImage(
                    $attachment->getLocalPath(),
                    $attachment->getFileContent(), // Content ID is inside the content here
                    $attachment->getFileName(),
                    $attachment->getEncoding(),
                    $attachment->getFileMime()
                );
            } elseif (Interfaces\ContentAttachment::TYPE_FILE == $attachment->getType()) {
                $this->mailer->addAttachment(
                    $attachment->getLocalPath(),
                    $attachment->getFileName(),
                    $attachment->getEncoding(),
                    $attachment->getFileMime()
                );
            } else {
                $this->mailer->addStringAttachment(
                    $attachment->getFileContent(),
                    $attachment->getFileName(),
                    $attachment->getEncoding(),
                    $attachment->getFileMime()
                );
            }
        }
        return $this;
    }

    protected function addUnsubscribe(Interfaces\Content $content)
    {
        $unSubscribeLink = $content->getUnsubscribeLink();
        $unSubscribeEmail = $content->getUnsubscribeEmail();
        if (!(empty($unSubscribeLink) || empty($unSubscribeEmail))) {
            if ($unSubscribeLink && $unSubscribeEmail) {
                if ($content->canUnsubscribeOneClick()) {
                    $this->mailer->addCustomHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
                }
                $this->mailer->addCustomHeader('List-Unsubscribe', '<' . $unSubscribeLink . '>, <' . $unSubscribeEmail . '>');
            } elseif ($unSubscribeLink) {
                if ($content->canUnsubscribeOneClick()) {
                    $this->mailer->addCustomHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
                }
                $this->mailer->addCustomHeader('List-Unsubscribe', '<' . $unSubscribeLink . '>');
            } else {
                $this->mailer->addCustomHeader('List-Unsubscribe', '<' . $unSubscribeEmail . '>');
            }
        }
        return $this;
    }

    /**
     * @return $this
     * @throws Mailer\Exception
     */
    protected function send()
    {
        $this->mailer->send();
        return $this;
    }
}
