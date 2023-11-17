<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Exception\RfcComplianceException;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Component\Security\Http\LoginLink\LoginLinkNotification;

class SecurityController extends AbstractController
{
    #[Route('/login-sent', name: 'app_login_sent')]
    public function loginSent()
    {
        return $this->render('security/login-sent.html.twig');
    }

    #[Route('/login', name: 'app_login')]
    public function login(NotifierInterface $notifier, LoginLinkHandlerInterface $loginLinkHandler, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home_index');
        }

        $email = $request->request->get('email');
        $error = false;

        if ($request->isMethod('POST')) {
            // load the user in some way (e.g. using the form input)
            try {
                $address = new Address($email);

                $user = $userRepository->findOneBy(['email' => $address->getAddress()]);

                if (null === $user) {
                    $user = new User();
                    $user->setEmail($address->getAddress());
                    $user->setPassword(uniqid());

                    $entityManager->persist($user);
                    $entityManager->flush();
                }

                $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

                $notification = new LoginLinkNotification(
                    $loginLinkDetails,
                    'PLease use the link to login!' // email subject
                );

                $recipient = new Recipient($user->getEmail());

                $notifier->send($notification, $recipient);

                return $this->redirectToRoute('app_login_sent');

            } catch (RfcComplianceException $exception) {
                // nope
                $error = 'Email does not look like an email';
            }
        }

        //        $error = $authenticationUtils->getLastAuthenticationError();
        //        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'email' => $email,
        ]);
    }

    #[Route('/login_check', name: 'app_login_check')]
    public function check(): never
    {
        throw new \LogicException('This code should never be reached');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
