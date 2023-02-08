<?php

namespace App\Repository;

use App\Entity\CommentNotation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentNotation>
 *
 * @method CommentNotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentNotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentNotation[]    findAll()
 * @method CommentNotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentNotationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentNotation::class);
    }

    public function save(CommentNotation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommentNotation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
