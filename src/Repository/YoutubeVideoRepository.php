<?php

namespace App\Repository;

use App\Entity\YoutubeCategory;
use App\Entity\YoutubeVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method YoutubeVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method YoutubeVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method YoutubeVideo[]    findAll()
 * @method YoutubeVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YoutubeVideoRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, YoutubeVideo::class);
        $this->paginator = $paginator;
    }

    public function getRandom(YoutubeCategory $youtubeCategory = null)
    {
        $qb = $this->createQueryBuilder('youtubeVideo');
        if (null !== $youtubeCategory) {
            $qb->where('youtubeVideo.category = :category');
            $qb->setParameter('category', $youtubeCategory);
        }

        $qq = clone $qb;

        $qb->select('count(youtubeVideo.id)');
        $count = $qb->getQuery()->getSingleScalarResult();

        $qq->setMaxResults(1);
        $qq->setFirstResult(mt_rand(0, $count - 1));

        return $qq->getQuery()->getOneOrNullResult();
    }

    public function findPaginated(int $page = 1, string $search = null, YoutubeCategory $youtubeCategory = null)
    {
        $qb = $this->createQueryBuilder('youtubeVideo');

        if ($search) {
            $qb->andWhere('youtubeVideo.name LIKE :search');
            $qb->setParameter('search', "%$search%");
        }

        if (null !== $youtubeCategory) {
            $qb->andWhere('youtubeVideo.category = :category');
            $qb->setParameter('category', $youtubeCategory);
        }

//        if (null !== $public) {
//            $qb->andWhere('youtubeVideo.public = :public');
//            $qb->setParameter('public', $public);
//        }

        return $this->paginator->paginate($qb, $page, 24, [
            PaginatorInterface::DEFAULT_SORT_FIELD_NAME => 'youtubeVideo.created',
            PaginatorInterface::DEFAULT_SORT_DIRECTION => 'desc',
        ]);
    }
}
