<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

// Fiche démo 1-2 : Ajout du service Sendr
use App\Notification\Sendr;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             UserAuthenticatorInterface $userAuthenticator,
                             AppCustomAuthenticator $authenticator,
                             EntityManagerInterface $entityManager,
                             // Fiche démo 1-2 : Ajout du service Sendr
                             Sendr $mailSender): Response
    {
        $user = new Participant();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Ligne à ajouter : attribue le rôle ROLE_USER par défaut
            $user->setRoles(["ROLE_USER"]);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // Fiche démo 2 : Appel du service $Sendr pour notifier
            // les administrateurs de l'inscription du nouvel utilisateur
            $mailSender->sendNewUserNotificationsToAdmins($user);

           return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
