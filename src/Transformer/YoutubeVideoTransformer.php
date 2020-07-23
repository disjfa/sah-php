<?php

namespace App\Transformer;

use App\Entity\Star;
use App\Entity\YoutubeVideo;
use App\Repository\StarRepository;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class YoutubeVideoTransformer extends TransformerAbstract
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserInterface|null
     */
    private $user;
    /**
     * @var StarRepository
     */
    private $starRepository;

    public function __construct(RouterInterface $router, Security $security, StarRepository $starRepository)
    {
        $this->router = $router;
        $this->user = $security->getUser();
        $this->starRepository = $starRepository;
    }

    public function transform(YoutubeVideo $youtubeVideo)
    {
        $data = [
            'id' => $youtubeVideo->getId(),
            'title' => $youtubeVideo->getName(),
            'video' => $youtubeVideo->getVideo(),
            'duration' => $youtubeVideo->getDuration(),
        ];

        $links = [
            'url' => $this->router->generate('home_video', [
                'video' => $youtubeVideo->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'video' => $this->router->generate('api_video_video', [
                'video' => $youtubeVideo->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        if ($this->user instanceof UserInterface) {
            $links['star'] = $this->router->generate('api_video_star_video', [
                'video' => $youtubeVideo->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);

            $star = $this->starRepository->findOneByItemAndUser($youtubeVideo, $this->user);

            $data['star'] = $star instanceof Star;
        }

        $data['links'] = $links;

        return $data;
    }
}
