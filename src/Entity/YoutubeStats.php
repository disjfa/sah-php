<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YoutubeStatsRepository")
 */
class YoutubeStats
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @var YoutubeVideo|null
     * @ORM\ManyToOne(targetEntity="App\Entity\YoutubeVideo")
     */
    private $video;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function __construct(YoutubeVideo $youtubeVideo, string $type, UserInterface $user = null)
    {
        $this->video = $youtubeVideo;
        $this->type = $type;
        $this->user = $user;
        $this->created = new DateTime('now');
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getVideo(): ?YoutubeVideo
    {
        return $this->video;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }
}
