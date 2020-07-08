<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YoutubeCategoryRepository")
 */
class YoutubeCategory
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $seqnr;

    /**
     * @var YoutubeVideo[]|Collection
     * @ORM\OneToMany(targetEntity="App\Entity\YoutubeVideo", mappedBy="category")
     */
    private $videos;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    public function __construct()
    {
        $this->seqnr = 50;
        $this->videos = new ArrayCollection();
        $this->created = new DateTime('now');
        $this->updated = new DateTime('now');
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeqnr(): int
    {
        return $this->seqnr;
    }

    /**
     * @param int $seqnr
     */
    public function setSeqnr(int $seqnr): void
    {
        $this->seqnr = $seqnr;
    }

    /**
     * @return YoutubeVideo[]|Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param YoutubeVideo[]|Collection $videos
     */
    public function setVideos($videos): void
    {
        $this->videos = $videos;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
