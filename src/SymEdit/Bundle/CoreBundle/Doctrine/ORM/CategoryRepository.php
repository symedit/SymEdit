<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
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
        $root = $this->createNew();
        $root->setChildren($this->findRoots());

        return $root;
    }
}