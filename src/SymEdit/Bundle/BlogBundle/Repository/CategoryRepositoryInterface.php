<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\BlogBundle\Model\CategoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all root categories.
     *
     * @return CategoryInterface[]
     */
    public function findRoots();

    /**
     * Returns a blank category with children set as roots.
     *
     * @return CategoryInterface
     */
    public function findRoot();
}
