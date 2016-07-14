<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ImageGalleryInterface extends ResourceInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getSlug();

    public function getItems();

    public function addItem(GalleryItemInterface $image);

    public function removeItem(GalleryItemInterface $image);

    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return \DateTime Time of late update
     */
    public function getUpdatedAt();
}
