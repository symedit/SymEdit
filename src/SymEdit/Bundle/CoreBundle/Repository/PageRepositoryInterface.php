<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Iterator\RecursivePageIterator;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;

interface PageRepositoryInterface extends RepositoryInterface
{
    /**
     * Gets root Page.
     *
     * @return PageInterface
     */
    public function findRoot();

    /**
     * Get page iterator.
     *
     * @param bool $display Whether or not to get pages with display set
     *
     * @return RecursivePageIterator
     */
    public function getIterator($display = true);

    /**
     * Get recursive iterator.
     *
     * @param bool $display Whether or not to get pages with display set
     *
     * @return \RecursiveIteratorIterator
     */
    public function getRecursiveIterator($display = true);

    /**
     * Get all pages with page controllers.
     *
     * @return PageInterface[]
     */
    public function findPageControllers();

    /**
     * Get last updated Page.
     *
     * @return PageInterface
     */
    public function getLastUpdated();
}
