<?php

namespace SymEdit\Bundle\MediaBundle\Model;

interface GalleryItemInterface
{
    /**
     * @return integer $id
     */
    public function getId();

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image);

    /**
     * @return ImageInterface $image
     */
    public function getImage();

    /**
     * @param GalleryInterface $gallery
     */
    public function setGallery(ImageGalleryInterface $gallery);

    /**
     * @return GalleryInterface $gallery
     */
    public function getGallery();
}