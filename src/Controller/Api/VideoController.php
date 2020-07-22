<?php

namespace App\Controller\Api;

use App\Entity\Star;
use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use App\Repository\StarRepository;
use App\Repository\YoutubeVideoRepository;
use App\Transformer\YoutubeVideoTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/video")
 */
class VideoController extends AbstractController
{
    /**
     * @var YoutubeVideoRepository
     */
    private $youtubeVideoRepository;
    /**
     * @var YoutubeVideoTransformer
     */
    private $youtubeVideoTransformer;

    public function __construct(YoutubeVideoRepository $youtubeVideoRepository, YoutubeVideoTransformer $youtubeVideoTransformer)
    {
        $this->youtubeVideoRepository = $youtubeVideoRepository;
        $this->youtubeVideoTransformer = $youtubeVideoTransformer;
    }

    /**
     * @Route("/random", name="api_video_random")
     */
    public function random()
    {
        $video = $this->youtubeVideoRepository->getRandom();
        $item = new Item($video, $this->youtubeVideoTransformer);
        $manager = new Manager();

        return new JsonResponse($manager->createData($item)->toArray());
    }

    /**
     * @Route("/random/{category}", name="api_video_random_category")
     */
    public function randomCategory(YoutubeCategory $category)
    {
        $video = $this->youtubeVideoRepository->getRandom($category);
        $item = new Item($video, $this->youtubeVideoTransformer);
        $manager = new Manager();

        return new JsonResponse($manager->createData($item)->toArray());
    }

    /**
     * @Route("/star/{video}", name="api_video_star_video")
     */
    public function starVideo(YoutubeVideo $video, StarRepository $starRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $star = $starRepository->findOneByItemAndUser($video, $user);

        if (null === $starRepository->findOneByItemAndUser($video, $user)) {
            $star = new Star($video, $user);
            $em->persist($star);
            $em->flush();
            $message = 'starred';
        } else {
            $em->remove($star);
            $em->flush();
            $message = 'deleted';
        }

        return new JsonResponse(['message' => $message]);
    }
}
