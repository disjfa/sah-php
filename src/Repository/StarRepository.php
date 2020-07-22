<?php

namespace App\Repository;

use App\Entity\Star;
use App\Entity\YoutubeVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Star|null find($id, $lockMode = null, $lockVersion = null)
 * @method Star|null findOneBy(array $criteria, array $orderBy = null)
 * @method Star[]    findAll()
 * @method Star[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Star::class);
    }

    /**
     * @return Star|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneByItemAndUser(YoutubeVideo $video, UserInterface $user)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->where('l.video = :video');
        $qb->andWhere('l.user = :user');
        $qb->setParameter('video', $video);
        $qb->setParameter('user', $user);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
