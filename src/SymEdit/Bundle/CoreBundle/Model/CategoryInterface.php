<?php

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\BlogBundle\Model\CategoryInterface as BaseCategoryInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

interface CategoryInterface extends BaseCategoryInterface, SeoAbleInterface
{
    
}