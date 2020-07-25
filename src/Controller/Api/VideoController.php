<?php

namespace App\Controller\Api;

use App\Entity\Star;
use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use App\Manager\YoutubeStatsManager;
use App\Repository\StarRepository;
use App\Repository\YoutubeVideoRepository;
use App\Transformer\YoutubeVideoTransformer;
use Doctrine\ORM\NonUniqueResultException;
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
    public function randomCategory(YoutubeCategory $category, YoutubeStatsManager $youtubeStatsManager)
    {
        $video = $this->youtubeVideoRepository->getRandom($category);
        $item = new Item($video, $this->youtubeVideoTransformer);
        $manager = new Manager();

        $youtubeStatsManager->add($video, 'random');

        return new JsonResponse($manager->createData($item)->toArray());
    }

    /**
     * @Route("/video/{video}", name="api_video_video")
     */
    public function video(YoutubeVideo $video)
    {
        $item = new Item($video, $this->youtubeVideoTransformer);
        $manager = new Manager();

        return new JsonResponse($manager->createData($item)->toArray());
    }

    /**
     * @Route("/video/{video}/finish", name="api_video_video_finish")
     */
    public function finish(YoutubeVideo $video, YoutubeStatsManager $youtubeStatsManager)
    {
        $item = new Item($video, $this->youtubeVideoTransformer);
        $manager = new Manager();

        $youtubeStatsManager->add($video, 'finish');

        return new JsonResponse($manager->createData($item)->toArray());
    }

    /**
     * @Route("/star/{video}", name="api_video_star_video")
     *
     * @throws NonUniqueResultException
     */
    public function starVideo(YoutubeVideo $video, StarRepository $starRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $star = $starRepository->findOneByItemAndUser($video, $user);

        if (null === $star) {
            $star = new Star($video, $user);
            $em->persist($star);
            $em->flush();
        } else {
            $em->remove($star);
            $em->flush();
        }

        $item = new Item($video, $this->youtubeVideoTransformer);
        $manager = new Manager();

        return new JsonResponse($manager->createData($item)->toArray());
    }
}
