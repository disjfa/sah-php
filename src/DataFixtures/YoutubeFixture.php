<?php

namespace App\DataFixtures;

use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class YoutubeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            [
                'name' => 'Clips',
                'videos' => [
                    [
                        'video' => 'JTMVOzPPtiw',
                        'name' => 'Limp Bizkit - Nookie (Official Video)',
                        'duration' => 269,
                    ],
                    [
                        'video' => 'qORYO0atB6g',
                        'name' => 'Beastie Boys - Intergalactic',
                        'duration' => 274,
                    ],
                    [
                        'video' => 'pMl3exzgGto',
                        'name' => 'THY ART IS MURDER - Human Target (OFFICIAL MUSIC VIDEO)',
                        'duration' => 211,
                    ],
                    [
                        'video' => 'B1zCN0YhW1s',
                        'name' => 'Slipknot - Wait And Bleed [OFFICIAL VIDEO]',
                        'duration' => 166,
                    ],
                    [
                        'video' => '6ODNxy3YOPU',
                        'name' => 'Sepultura - Refuse/Resist [OFFICIAL VIDEO]',
                        'duration' => 199,
                    ],
                ],
            ],
            [
                'name' => 'Concerten',
                'videos' => [
                    [
                        'video' => 'ScfM-fIdFOQ',
                        'name' => 'Therapy? - Full Show - Live at Wacken Open Air 2016',
                        'duration' => 2799,
                    ],
                ],
            ],
        ];

        foreach ($categories as $seqnr => $cat) {
            $category = new YoutubeCategory();
            $category->setName($cat['name']);
            $category->setSeqnr($seqnr);
            $manager->persist($category);

            foreach ($cat['videos'] as $vid) {
                $video = new YoutubeVideo();
                $video->setCategory($category);
                $video->setName($vid['name']);
                $video->setVideo($vid['video']);
                $video->setDuration($vid['duration']);
                $video->setPublic(true);
                $manager->persist($video);
            }
        }

        $manager->flush();
    }
}
