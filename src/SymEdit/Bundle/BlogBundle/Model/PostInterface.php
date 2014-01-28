<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Model;

use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;
use SymEdit\Bundle\CoreBundle\Model\ViewCountableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface PostInterface extends SeoAbleInterface, ViewCountableInterface
{
    public function getId();

    public function setTitle($title);
    public function getTitle();

    public function setSlug($slug);
    public function getSlug();

    public function setContent($content);
    public function getContent();

    public function setAuthor(UserInterface $author = null);
    public function getAuthor();

    public function setImage(ImageInterface $image = null);
    public function getImage();

    public function setCreatedAt($createdAt);
    public function getCreatedAt();

    public function setSummary($summary);
    public function getSummary();

    public function setStatus($status);
    public function getStatus();

    public function addCategory(CategoryInterface $category);
    public function removeCategory(CategoryInterface $category);
    public function getCategories();

    public function isPublished();
}
