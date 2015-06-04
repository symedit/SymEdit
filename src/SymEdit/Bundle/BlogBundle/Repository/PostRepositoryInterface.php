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

use Pagerfanta\PagerfantaInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\BlogBundle\Model\CategoryInterface;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function findPublished();

    public function findByCategory(CategoryInterface $category);

    /**
     * @return PagerfantaInterface
     */
    public function getCategoryPaginator(CategoryInterface $category);

    public function getRecent($max);

    /**
     * @return PostInterface Get the latest post
     */
    public function getLatestPost();

    /**
     * @return PagerfantaInterface
     */
    public function getCreatedAtPaginator();
}
