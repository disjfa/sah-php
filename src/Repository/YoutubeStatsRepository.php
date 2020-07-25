<?php

namespace App\Repository;

use App\Entity\YoutubeStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method YoutubeStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method YoutubeStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method YoutubeStats[]    findAll()
 * @method YoutubeStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YoutubeStatsRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, YoutubeStats::class);
        $this->paginator = $paginator;
    }

    public function findPaginated(int $page = 1)
    {
        $qb = $this->createQueryBuilder('youtube_stats');

        return $this->paginator->paginate($qb, $page, 24, [
            PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'youtube_stats.created',
            PaginatorInterface::DEFAULT_SORT_DIRECTION => 'desc',
        ]);
    }
}
