<?php

namespace App\Transformer;

use App\Entity\YoutubeVideo;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class YoutubeVideoTransformer extends TransformerAbstract
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function transform(YoutubeVideo $youtubeVideo)
    {
        return [
            'id' => $youtubeVideo->getId(),
            'url' => $this->router->generate('home_video', [
                'video' => $youtubeVideo->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'title' => $youtubeVideo->getName(),
            'video' => $youtubeVideo->getVideo(),
            'duration' => $youtubeVideo->getDuration(),
        ];
    }
}
