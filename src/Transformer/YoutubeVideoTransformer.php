<?php

namespace App\Transformer;

use App\Entity\YoutubeVideo;
use League\Fractal\TransformerAbstract;

class YoutubeVideoTransformer extends TransformerAbstract
{
    public function transform(YoutubeVideo $youtubeVideo)
    {
        return [
            'id' => $youtubeVideo->getId(),
            'title' => $youtubeVideo->getName(),
            'video' => $youtubeVideo->getVideo(),
            'duration' => $youtubeVideo->getDuration(),
        ];
    }
}
