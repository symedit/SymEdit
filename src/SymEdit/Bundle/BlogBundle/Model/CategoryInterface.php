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

use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

interface CategoryInterface extends SeoAbleInterface
{
    public function getId();

    public function setName($name);
    public function getName();

    public function setTitle($title);
    public function getTitle();

    public function setSlug($slug);
    public function getSlug();

    public function setParent(CategoryInterface $parent = null);
    public function getParent();

    public function getLevel();
    public function setLevel($level);

    public function addChildren(CategoryInterface $children);
    public function removeChildren(CategoryInterface $children);
    public function getChildren();

    public function addPost(Post $post);
    public function removePost(Post $post);
    public function getPosts();
    public function getPublishedPosts();
    public function getTotal();
    public function getRoot();
}
