<?php

namespace App\Infrastructure\Mailing;

use App\Infrastructure\Queue\Message\ServiceMethodMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class Mailer
{
    private Environment $twig;
    private MessageBusInterface $messageBus;

    public function __construct(Environment $twig, MessageBusInterface $messageBus)
    {
        $this->twig = $twig;
        $this->messageBus = $messageBus;
    }

    public function createEmail(string $template, array $data = []): Email
    {
        $this->twig->addGlobal('format', 'html');
        $html = $this->twig->render($template, array_merge($data, ['layout' => 'mails/base.html.twig']));
        $this->twig->addGlobal('format', 'text');
        $text = $this->twig->render($template, array_merge($data, ['layout' => 'mails/base.text.twig']));

        return (new Email())
            ->from('noreply@grafikart.fr')
            ->html($html)
            ->text($text);
    }

    public function send(Email $email): void
    {
        $this->messageBus->dispatch(
            new ServiceMethodMessage(MailerInterface::class, 'send', [$email])
        );
    }
}
