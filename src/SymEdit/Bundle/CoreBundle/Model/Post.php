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

use SymEdit\Bundle\BlogBundle\Model\Post as BasePost;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;

class Post extends BasePost implements PostInterface
{
    /**
     * @var ImageInterface
     */
    protected $image;

    /**
     * @var array
     */
    protected $seo;

    /**
     * Set image.
     *
     * @param ImageInterface $image
     *
     * @return Post
     */
    public function setImage(ImageInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return ImageInterface
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set seo.
     *
     * @param array $seo
     *
     * @return Post
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
