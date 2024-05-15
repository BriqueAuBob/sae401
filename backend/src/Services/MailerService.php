<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer
    ) {}

    public function sendEmail(string $to, string $subject, string $html): void
    {
        try {
            $email = (new Email())
                ->from('contact@weatherapp.iut-troyes.fr')
                ->to($to)
                ->subject("WeatherApp - $subject")
                ->html($html)
                ->text(strip_tags($html));

            $this->mailer->send($email);
        } catch(\Exception $e) {}
    }
}