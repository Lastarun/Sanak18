<?php

namespace AppBundle\Repository;

use AppBundle\Entity\News;

class NewsRepository extends \Doctrine\ORM\EntityRepository
{
    public function findNewsById($id)
    {
        return $this->getEntityManager()->
        createQuery(
            'SELECT n FROM AppBundle:News n WHERE n.id=:id '
        )
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }
}