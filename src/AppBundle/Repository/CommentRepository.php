<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Comment;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findNewsById($id)
    {
        return $this->getEntityManager()->
        createQuery(
            'SELECT n FROM AppBundle:Comment n WHERE n.id=:id'
        )
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }
}