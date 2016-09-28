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

use SymEdit\Bundle\CoreBundle\Model\Post;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * @return Post
     */
    protected function getPost()
    {
        return new Post();
    }

    public function testImage()
    {
        $post = $this->getPost();
        $post->setSlug('foo');
        $this->assertNull($post->getImage());

        $image = $this->getMockBuilder('SymEdit\Bundle\MediaBundle\Model\ImageInterface')
            ->getMock()
        ;
        
        $post->setImage($image);
        $this->assertEquals($image, $post->getImage());
    }

    public function testSeo()
    {
        $post = $this->getPost();
        $this->assertNull($post->getSeo());

        $seo = ['title' => 'foo'];
        $post->setSeo($seo);
        $this->assertEquals($seo, $post->getSeo());
    }
}
