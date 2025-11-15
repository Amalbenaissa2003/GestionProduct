<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher ,MailerInterface $mailer): Response
    {
        $user = new User();

        // Création du formulaire
        $form = $this->createFormBuilder($user)
            ->add('first_name', TextType::class, ['label' => 'First Name'])
            ->add('last_name', TextType::class, ['label' => 'Last Name'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('phone', TelType::class, ['label' => 'Phone'])
            ->add('password', PasswordType::class, ['label' => 'Password'])
            ->add('register', SubmitType::class, ['label' => 'Register'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $user->setPassword(
                $passwordHasher->hashPassword($user, $user->getPassword())
            );

            // Rôle par défaut
            $user->setRoles(['ROLE_USER']);

            $em->persist($user);
            $em->flush();

             // ----------- 📧 Envoi email automatique ----------------
            $email = (new Email())
                ->to($user->getEmail()) // email du nouvel utilisateur
                ->subject('Welcome to our website! !')
                ->html("
                    <h2>Hello {$user->getFirstName()} !</h2>
                    <p>Your registration was successful.</p>
                    <p>Thank you for joining our platform.</p>
                ");

            $mailer->send($email);
            // ---------------------------------------------------------

            $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
