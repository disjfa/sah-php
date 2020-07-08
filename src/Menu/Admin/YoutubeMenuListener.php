<?php

namespace App\Menu\Admin;

use Disjfa\MenuBundle\Menu\ConfigureAdminMenu;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class YoutubeMenuListener implements EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function onMenuConfigure(ConfigureAdminMenu $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('youtube_video', [
            'route' => 'admin_youtube_video_index',
            'label' => $this->translator->trans('admin.menu.youtube_video'),
        ])->setExtra('icon', 'fa-fw fa-video');
        $menu->addChild('youtube_category', [
            'route' => 'admin_youtube_category_index',
            'label' => $this->translator->trans('admin.menu.youtube_category'),
        ])->setExtra('icon', 'fa-fw fa-tags');
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigureAdminMenu::class => ['onMenuConfigure', 50],
        ];
    }
}
