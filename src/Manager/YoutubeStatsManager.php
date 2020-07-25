<?php

namespace App\Manager;

use App\Entity\YoutubeStats;
use App\Entity\YoutubeVideo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class YoutubeStatsManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserInterface|null
     */
    private $user;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->user = $security->getUser();
    }

    public function add(YoutubeVideo $video, string $type)
    {
        $youtubeStats = new YoutubeStats($video, $type, $this->user);

        $this->entityManager->persist($youtubeStats);
        $this->entityManager->flush();
    }
}
