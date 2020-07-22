<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Exception;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StarRepository")
 * @ORM\Table(
 *     uniqueConstraints={@UniqueConstraint(name="user_video", columns={"video_id", "user_id"})},
 *     indexes={@Index(name="user_video_index", columns={"video_id", "user_id"})}
 * )
 */
class Star
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
     * @var YoutubeVideo
     * @ORM\ManyToOne(targetEntity="App\Entity\YoutubeVideo", inversedBy="stars")
     */
    private $video;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @throws Exception
     */
    public function __construct(YoutubeVideo $video, User $user)
    {
        $this->video = $video;
        $this->user = $user;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getVideo(): YoutubeVideo
    {
        return $this->video;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
