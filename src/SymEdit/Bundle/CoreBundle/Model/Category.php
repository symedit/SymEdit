<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\BlogBundle\Model\Category as BaseCategory;

class Category extends BaseCategory implements CategoryInterface
{
    /**
     * @var array
     */
    protected $seo;

    /**
     * Set seo.
     *
     * @param array $seo
     *
     * @return CategoryInterface
     */
    public function setSeo(array $seo = [])
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo.
     *
     * @return array
     */
    public function getSeo()
    {
        return $this->seo;
    }
}
