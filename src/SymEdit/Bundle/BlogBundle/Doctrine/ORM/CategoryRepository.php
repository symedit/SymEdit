<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use SymEdit\Bundle\BlogBundle\Model\Category;
use SymEdit\Bundle\BlogBundle\Repository\CategoryRepositoryInterface;

class CategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findRoots()
    {
        return $this->findBy([
            'parent' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function findRoot()
    {
        $root = new Category();
        $root->setChildren($this->findRoots());

        return $root;
    }
}
