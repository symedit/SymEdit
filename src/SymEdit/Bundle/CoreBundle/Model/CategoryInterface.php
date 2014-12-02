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

use SymEdit\Bundle\BlogBundle\Model\CategoryInterface as BaseCategoryInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

interface CategoryInterface extends BaseCategoryInterface, SeoAbleInterface
{
}
