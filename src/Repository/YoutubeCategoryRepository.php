<?php

namespace App\Repository;

use App\Entity\YoutubeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method YoutubeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method YoutubeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method YoutubeCategory[]    findAll()
 * @method YoutubeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YoutubeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YoutubeCategory::class);
    }
}
