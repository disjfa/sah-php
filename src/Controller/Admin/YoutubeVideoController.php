<?php

namespace App\Controller\Admin;

use App\Entity\YoutubeVideo;
use App\Form\YoutubeVideoQueryType;
use App\Form\YoutubeVideoType;
use App\Query\YoutubeVideoQuery;
use App\Repository\YoutubeVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $youtubeVideoQuery = new YoutubeVideoQuery(null);
        $searchForm = $this->createForm(YoutubeVideoQueryType::class, $youtubeVideoQuery);
        $searchForm->handleRequest($request);

        return $this->render('admin/youtube_video/index.html.twig', [
            'youtube_videos' => $youtubeVideoRepository->findPaginated($request->query->getInt('page', 1), $youtubeVideoQuery),
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("/new", name="admin_youtube_video_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $youtubeVideo = new YoutubeVideo();
        $youtubeVideo->setPublic(true);
        $form = $this->createForm(YoutubeVideoType::class, $youtubeVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function edit(Request $request, YoutubeVideo $youtubeVideo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(YoutubeVideoType::class, $youtubeVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

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
    public function delete(Request $request, YoutubeVideo $youtubeVideo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$youtubeVideo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($youtubeVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_youtube_video_index');
    }
}
