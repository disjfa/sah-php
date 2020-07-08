<?php

namespace App\Controller\Admin;

use App\Entity\YoutubeVideo;
use App\Form\YoutubeVideoType;
use App\Repository\YoutubeVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/youtube/video")
 */
class YoutubeVideoController extends AbstractController
{
    /**
     * @Route("/", name="admin_youtube_video_index", methods={"GET"})
     */
    public function index(YoutubeVideoRepository $youtubeVideoRepository, Request $request): Response
    {
        return $this->render('admin/youtube_video/index.html.twig', [
            'youtube_videos' => $youtubeVideoRepository->findPaginated($request->query->getInt('page', 1), $request->query->get('q')),
        ]);
    }

    /**
     * @Route("/new", name="admin_youtube_video_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $youtubeVideo = new YoutubeVideo();
        $form = $this->createForm(YoutubeVideoType::class, $youtubeVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($youtubeVideo);
            $entityManager->flush();

            return $this->redirectToRoute('admin_youtube_video_index');
        }

        return $this->render('admin/youtube_video/new.html.twig', [
            'youtube_video' => $youtubeVideo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_youtube_video_show", methods={"GET"})
     */
    public function show(YoutubeVideo $youtubeVideo): Response
    {
        return $this->render('admin/youtube_video/show.html.twig', [
            'youtube_video' => $youtubeVideo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_youtube_video_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, YoutubeVideo $youtubeVideo): Response
    {
        $form = $this->createForm(YoutubeVideoType::class, $youtubeVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_youtube_video_index');
        }

        return $this->render('admin/youtube_video/edit.html.twig', [
            'youtube_video' => $youtubeVideo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_youtube_video_delete", methods={"DELETE"})
     */
    public function delete(Request $request, YoutubeVideo $youtubeVideo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$youtubeVideo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($youtubeVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_youtube_video_index');
    }
}
