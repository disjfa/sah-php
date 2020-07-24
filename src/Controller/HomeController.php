<?php

namespace App\Controller;

use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use App\Form\YoutubeVideoQueryType;
use App\Query\YoutubeVideoQuery;
use App\Repository\StarRepository;
use App\Repository\YoutubeCategoryRepository;
use App\Repository\YoutubeVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $youtubeVideoQuery = new YoutubeVideoQuery();
        $youtubeVideoQuery->setCategory($category);

        $videos = $youtubeVideoRepository->findPaginated($request->query->getInt('page', 1), $youtubeVideoQuery);

        return $this->render('home/category.html.twig', [
            'videos' => $videos,
            'category' => $category,
        ]);
    }

    /**
     * @Route("/video/{video}", name="home_video")
     */
    public function video(YoutubeVideo $video, StarRepository $starRepository)
    {
        $star = null;
        if ($this->getUser() instanceof UserInterface) {
            $star = $starRepository->findOneByItemAndUser($video, $this->getUser());
        }

        return $this->render('home/video.html.twig', [
            'video' => $video,
            'star' => $star,
        ]);
    }

    /**
     * @Route("/search", name="home_search")
     */
    public function search(YoutubeVideoRepository $youtubeVideoRepository, Request $request)
    {
        $youtubeVideoQuery = new YoutubeVideoQuery();

        $searchForm = $this->createForm(YoutubeVideoQueryType::class, $youtubeVideoQuery);
        $searchForm->handleRequest($request);

        $videos = $youtubeVideoRepository->findPaginated($request->query->getInt('page', 1), $youtubeVideoQuery);

        return $this->render('home/search.html.twig', [
            'videos' => $videos,
            'searchForm' => $searchForm->createView(),
            'random' => $youtubeVideoRepository->getRandom(),
        ]);
    }
}
