<?php

namespace Labs\BackBundle\Repository;

use Doctrine\ORM\Query\Expr;

/**
 * DossierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOne($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where($qb->expr()->eq('p.id', ':id'));
        $qb->setParameter(':id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOneAndAssociation($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->leftJoin('p.medias','m');
        $qb->addSelect('m');
        $qb->where($qb->expr()->eq('p.id', ':id'));
        $qb->setParameter(':id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findProjectLimit($num = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.created', 'DESC');
        if( null !== $num ){
            $qb->setMaxResults($num);
        }
        return $qb->getQuery()->getResult();
    }
}
