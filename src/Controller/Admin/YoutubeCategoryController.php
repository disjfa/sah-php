<?php

namespace App\Controller\Admin;

use App\Entity\YoutubeCategory;
use App\Form\YoutubeCategoryType;
use App\Repository\YoutubeCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/youtube/category")
 */
class YoutubeCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_youtube_category_index", methods={"GET"})
     */
    public function index(YoutubeCategoryRepository $youtubeCategoryRepository): Response
    {
        return $this->render('admin/youtube_category/index.html.twig', [
            'youtube_categories' => $youtubeCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_youtube_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $youtubeCategory = new YoutubeCategory();
        $form = $this->createForm(YoutubeCategoryType::class, $youtubeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($youtubeCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_youtube_category_index');
        }

        return $this->render('admin/youtube_category/new.html.twig', [
            'youtube_category' => $youtubeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_youtube_category_show", methods={"GET"})
     */
    public function show(YoutubeCategory $youtubeCategory): Response
    {
        return $this->render('admin/youtube_category/show.html.twig', [
            'youtube_category' => $youtubeCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_youtube_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, YoutubeCategory $youtubeCategory): Response
    {
        $form = $this->createForm(YoutubeCategoryType::class, $youtubeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_youtube_category_index');
        }

        return $this->render('admin/youtube_category/edit.html.twig', [
            'youtube_category' => $youtubeCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_youtube_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, YoutubeCategory $youtubeCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$youtubeCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($youtubeCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_youtube_category_index');
    }
}
