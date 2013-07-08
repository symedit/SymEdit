<?php

namespace Isometriks\Bundle\SymEditBundle\Repository;

use Gedmo\Tree\Entity\Repository\MaterializedPathRepository; 

class PageRepository extends MaterializedPathRepository
{
    public function findRoot()
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT p FROM IsometriksSymEditBundle:Page p WHERE p.root = true')
                    ->getSingleResult();
    }

    /**
     * Get pages that are actually routes, this means pages that aren't
     * the root node, or page controllers
     */
    public function findCMSPages($display = null)
    {
        $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('p')
                ->from('IsometriksSymEditBundle:Page', 'p')
                ->where('p.root = false AND p.pageController = false');

        if ($display !== null) {
            $query->andWhere('p.display = :display')
                  ->setParameter('display', $display);
        }

        return $query->getQuery()->getResult();
    }
    
    public function findPageControllers()
    {
        return $this->findBy(array(
            'pageController' => true
        )); 
    }

    public function getPath($path)
    {
        return $this->findOneByPath($path);
    }
}