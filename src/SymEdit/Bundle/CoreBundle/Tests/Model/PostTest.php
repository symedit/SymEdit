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

        $image = $this->getMock('SymEdit\Bundle\MediaBundle\Model\Image');
        $image->expects($this->once())
              ->method('setNameCallBack');

        $post->setImage($image);
        $this->assertEquals($image, $post->getImage());
    }
}
