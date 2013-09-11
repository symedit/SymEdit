<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\Orm\Repository;

use Doctrine\ORM\EntityRepository;
use Isometriks\Bundle\SymEditBundle\Entity\Category;

class CategoryRepository extends EntityRepository {

    public function findRoots()
    {
        return $this->findBy(array(
            'parent' => null,
        ));
    }

    /*
     * Creates a blank category with all the roots as the children.
     */
    public function findRoot()
    {
        $root = new Category();
        $root->setChildren($this->findRoots());

        return $root;
    }
}