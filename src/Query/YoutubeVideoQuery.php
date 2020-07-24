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
     * @return string|null
     */
    public function getQ(): ?string
    {
        return $this->q;
    }

    /**
     * @param string|null $q
     */
    public function setQ(?string $q): void
    {
        $this->q = $q;
    }

    /**
     * @return YoutubeCategory|null
     */
    public function getCategory(): ?YoutubeCategory
    {
        return $this->category;
    }

    /**
     * @param YoutubeCategory|null $category
     */
    public function setCategory(?YoutubeCategory $category): void
    {
        $this->category = $category;
    }
}
