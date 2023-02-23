<?php
// https://code2dev.go.yo.fr/cours/outils_wamp/wamp_mails_papercut.php
// https://code2dev.go.yo.fr/cours/outils_wamp/wamp_mails_index.php
// https://symfony.com/doc/5.4/mailer.html

namespace App\Notification;

use App\Entity\Participant;
use App\Entity\Mailer\MailerInterface;
use App\Entity\Mime\Email;
	
class Sender
{
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    } // -- __construct()

    public function sendNewUserNotificationsToAdmins(Participant $participant): void
    {
        $message = new Email();
        $message->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Time to Symfony Mailer')
            ->text('Sending emails is fun again!')
            ->html('<p></p>');

        $this->mailer->send($message);

    } // -- sendNewUserNotificationsToAdmins()
} // -- class