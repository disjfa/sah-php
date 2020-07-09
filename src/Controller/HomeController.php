<?php

namespace App\Controller;

use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use App\Repository\YoutubeCategoryRepository;
use App\Repository\YoutubeVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(YoutubeCategoryRepository $categoryRepository)
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{category}", name="home_category")
     */
    public function category(YoutubeCategory $category, Request $request, YoutubeVideoRepository $youtubeVideoRepository)
    {
        $videos = $youtubeVideoRepository->findPaginated($request->query->getInt('page', 1), null, $category);

        return $this->render('home/category.html.twig', [
            'videos' => $videos,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/video/{video}", name="home_video")
     */
    public function video(YoutubeVideo $video)
    {
        return $this->render('home/video.html.twig', [
            'video' => $video,
        ]);
    }
}
