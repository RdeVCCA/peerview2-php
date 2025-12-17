<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Tools\Pagination\CountWalker;

/**
 * @extends ServiceEntityRepository<Note>
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function paginate(Query $query, int $pageNumber = 0, int $pageSize = 20): Paginator
    {
        $paginator = new Paginator($query);
        $paginator
            ->setUseOutputWalkers(false)
            ->getQuery()
            ->setFirstResult($pageNumber * $pageSize)
            ->setMaxResults($pageSize)
        ;
        return $paginator;
    }
}
