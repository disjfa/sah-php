<?php

namespace App\Transformer;

use App\Entity\YoutubeCategory;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class YoutubeCategoryTransformer extends TransformerAbstract
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserInterface|null
     */
    private $user;

    public function __construct(RouterInterface $router, Security $security)
    {
        $this->router = $router;
        $this->user = $security->getUser();
    }

    public function transform(YoutubeCategory $youtubeCategory)
    {
        $data = [
            'id' => $youtubeCategory->getId(),
            'title' => $youtubeCategory->getName(),
        ];

        $links = [
            'url' => $this->router->generate('home_category', [
                'category' => $youtubeCategory->getId(),
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        $data['links'] = $links;

        return $data;
    }
}
