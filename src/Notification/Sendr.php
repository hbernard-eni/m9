<?php
// https://code2dev.go.yo.fr/cours/outils_wamp/wamp_mails_papercut.php
// https://code2dev.go.yo.fr/cours/outils_wamp/wamp_mails_index.php
// https://symfony.com/doc/5.4/mailer.html

namespace App\Notification;

use App\Entity\Participant;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

// +++ Bug PhpStorm (?) : pas de coloration syntaxique si fichier nommé Sender.php (05/04/2022) +++
class Sendr
{
    private $mailer;
    private $capitalize;

    public function __construct(MailerInterface $mailer, Capitalize $capitalize) {

        // Mailer = un service de Symfony
        $this->mailer = $mailer;

        // Capitalize = un service 'perso'
        $this->capitalize = $capitalize;
    } // -- __construct()

    // Dans fiche démo : entité User = Participant
    public function sendNewUserNotificationsToAdmins(Participant $participant): void
    {
        $sLastname = $this->capitalize->toUpper($participant->getLastname() );

        $sContent = "L'utilisateur ".$participant->getFirstname()." ".$sLastname." vient de s'inscrire.";

        $sHtml = "<h1>Notification nouvel inscrit</h1>\n";
        $sHtml .= "<p>".$sContent."</p>\n";

        $oMessage = new Email();
        $oMessage->from('m9@m9.com')
                 ->to($participant->getEmail())
                 ->subject('Notification nouvel inscrit')
                 ->text($sContent)
                 ->html($sHtml);

        $this->mailer->send($oMessage);

    } // -- sendNewUserNotificationsToAdmins()
} // -- class