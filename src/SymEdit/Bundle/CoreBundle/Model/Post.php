<?php

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\BlogBundle\Model\Post as BasePost;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;

class Post extends BasePost
{
    /**
     * @var ImageInterface
     */
    protected $image;

   /**
     * Set image
     *
     * @param  ImageInterface $image
     * @return Post
     */
    public function setImage(ImageInterface $image = null)
    {
        $this->image = $image;

        if ($this->image !== null) {
            $this->setUpdatedAt(new \DateTime());
            $image->setNameCallback(function () {
                return ltrim($this->getSlug());
            });
        }

        return $this;
    }

    /**
     * Get image
     *
     * @return ImageInterface
     */
    public function getImage()
    {
        return $this->image;
    }
}