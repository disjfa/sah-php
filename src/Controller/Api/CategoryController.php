<?php

namespace App\Controller\Api;

use App\Repository\YoutubeCategoryRepository;
use App\Transformer\YoutubeCategoryTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @var YoutubeCategoryRepository
     */
    private $youtubeCategoryRepository;
    /**
     * @var YoutubeCategoryTransformer
     */
    private $youtubeCategoryTransformer;

    public function __construct(YoutubeCategoryRepository $youtubeCategoryRepository, YoutubeCategoryTransformer $youtubeCategoryTransformer)
    {
        $this->youtubeCategoryRepository = $youtubeCategoryRepository;
        $this->youtubeCategoryTransformer = $youtubeCategoryTransformer;
    }

    /**
     * @Route("", name="api_category_index")
     */
    public function index(Request $request)
    {
        $videos = $this->youtubeCategoryRepository->findAll();
        $items = new Collection($videos, $this->youtubeCategoryTransformer);

        $manager = new Manager();

        return new JsonResponse($manager->createData($items)->toArray());
    }
}
