<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\Orm\Repository;

use Gedmo\Tree\Entity\Repository\MaterializedPathRepository;

class PageRepository extends MaterializedPathRepository
{
    public function findRoot()
    {
        return $this->findOneBy(array(
            'root' => true,
        ));
    }

    /**
     * Get pages that are actually routes, this means pages that aren't
     * the root node, or page controllers
     */
    public function findCMSPages($display = null)
    {
        $criteria = array(
            'root' => false,
            'pageController' => false,
        );

        if ($display !== null) {
           $criteria['display'] = $display;
        }

        return $this->findBy($criteria);
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