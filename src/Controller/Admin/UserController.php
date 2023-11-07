<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users")
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("", name="admin_user_index")
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }

    private function handleUserForm(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user->getPassword()) {
                $user->setPassword(uniqid());
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_show', ['user' => $user->getId()]);
        }

        return $this->render('admin/user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="admin_user_create")
     *
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $user = new User();

        return $this->handleUserForm($user, $request, $entityManager);
    }

    /**
     * @Route("/{user}", name="admin_user_show")
     */
    public function show(User $user)
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{user}/edit", name="admin_user_edit")
     *
     * @return Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager)
    {
        return $this->handleUserForm($user, $request, $entityManager);
    }
}
