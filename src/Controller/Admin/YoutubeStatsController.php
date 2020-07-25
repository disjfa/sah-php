<?php

namespace App\Controller\Admin;

use App\Repository\YoutubeStatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/youtube/stats")
 */
class YoutubeStatsController extends AbstractController
{
    /**
     * @Route("/", name="admin_youtube_stats_index", methods={"GET"})
     */
    public function index(YoutubeStatsRepository $youtubeStatsRepository, Request $request): Response
    {
        return $this->render('admin/youtube_stats/index.html.twig', [
            'stats' => $youtubeStatsRepository->findPaginated($request->query->getInt('page', 1)),
        ]);
    }
}
