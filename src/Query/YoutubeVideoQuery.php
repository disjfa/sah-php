<?php

namespace App\Query;

use App\Entity\YoutubeCategory;

class YoutubeVideoQuery
{
    /**
     * @var string|null
     */
    private $q;

    /**
     * @var YoutubeCategory|null
     */
    private $category;

    /**
     * @var bool|null
     */
    private $public;

    public function __construct($public = true)
    {
        $this->public = $public;
    }

    public function getQ(): ?string
    {
        return $this->q;
    }

    public function setQ(?string $q): void
    {
        $this->q = $q;
    }

    public function getCategory(): ?YoutubeCategory
    {
        return $this->category;
    }

    public function setCategory(?YoutubeCategory $category): void
    {
        $this->category = $category;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(?bool $public): void
    {
        $this->public = $public;
    }
}
