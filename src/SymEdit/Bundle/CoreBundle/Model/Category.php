<?php

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\BlogBundle\Model\Category as BaseCategory;

class Category extends BaseCategory implements CategoryInterface
{
    /**
     * @var array $seo
     */
    protected $seo;

    /**
     * Set seo
     *
     * @param  array             $seo
     * @return CategoryInterface
     */
    public function setSeo(array $seo = array())
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return array
     */
    public function getSeo()
    {
        return $this->seo;
    }
}