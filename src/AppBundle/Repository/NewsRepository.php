<?php
    namespace AppBundle\Repository;
    use AppBundle\Entity\News;
    class NewsRepository extends \Doctrine\ORM\Persisters\EntityRepository
    {
        public function findNewsById($id)
        {
            return $this->getEntityManager()->
                CreateQuery(
                    ''
            )
        }
    }