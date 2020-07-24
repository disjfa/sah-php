<?php

namespace App\Menu\Site;

use App\Repository\YoutubeCategoryRepository;
use Disjfa\MenuBundle\Menu\ConfigureSiteMenu;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryMenuListener implements EventSubscriberInterface
{
    /**
     * @var YoutubeCategoryRepository
     */
    private $youtubeCategoryRepository;

    /**
     * HomeMenuListener constructor.
     */
    public function __construct(YoutubeCategoryRepository $youtubeCategoryRepository)
    {
        $this->youtubeCategoryRepository = $youtubeCategoryRepository;
    }

    public function onMenuConfigure(ConfigureSiteMenu $event)
    {
        $menu = $event->getMenu();

        $categories = $this->youtubeCategoryRepository->findBy([], ['seqnr' => 'asc']);
        foreach ($categories as $category) {
            $menu->addChild($category->getName(), [
                'route' => 'home_category',
                'routeParameters' => [
                    'category' => $category->getId(),
                ],
            ]);
        }

        $menu->addChild('search', [
            'route' => 'home_search',
            'label' => 'Zoeken',
        ]);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigureSiteMenu::class => ['onMenuConfigure', 999],
        ];
    }
}
