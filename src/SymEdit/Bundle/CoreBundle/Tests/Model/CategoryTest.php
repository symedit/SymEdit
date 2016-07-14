<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use SymEdit\Bundle\CoreBundle\Model\Category;
use SymEdit\Bundle\CoreBundle\Model\Post;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * @return Category
     */
    protected function getCategory()
    {
        $category = new Category();
        $category->setPosts(new ArrayCollection([
            new Post(),
        ]));

        return $category;
    }

    public function testSeo()
    {
        $seo = ['title' => 'foo'];
        $category = $this->getCategory()->setSeo($seo);

        $this->assertEquals($seo, $category->getSeo());
    }
}
