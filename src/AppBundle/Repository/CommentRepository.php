<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Comment;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByNewsId($id)
    {
        return $this->getEntityManager()->
        createQuery(
            'SELECT n FROM AppBundle:Comment n WHERE n.news_id=:id ORDER BY n.id DESC'
        )
            ->setParameter('id', $id)
            ->getResult();
    }
}