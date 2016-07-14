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

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * Interface CategoryInterface.
 */
interface CategoryInterface extends ResourceInterface
{
    /**
     * @return int $id
     */
    public function getId();

    /**
     * Set Category Name.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get Category Name.
     *
     * @return string $name
     */
    public function getName();

    /**
     * Set Category Title.
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return string $title
     */
    public function getTitle();

    /**
     * Set Slug.
     *
     * @param string $slug
     */
    public function setSlug($slug);

    /**
     * Get Slug.
     *
     * @return string $slug
     */
    public function getSlug();

    /**
     * Set Category Parent.
     *
     * @param CategoryInterface $parent
     */
    public function setParent(CategoryInterface $parent = null);

    /**
     * Get Category Parent.
     *
     * @return CategoryInterface $parent
     */
    public function getParent();

    /**
     * Get Tree Level.
     *
     * @return int $level
     */
    public function getLevel();

    /**
     * Set Tree Level.
     *
     * @param int $level
     */
    public function setLevel($level);

    /**
     * Add Children to category.
     *
     * @param CategoryInterface $children
     */
    public function addChildren(CategoryInterface $children);

    /**
     * Remove Children from Category.
     *
     * @param CategoryInterface $children
     */
    public function removeChildren(CategoryInterface $children);

    /**
     * Get Children.
     *
     * @return CategoryInterface[]|ArrayCollection $children
     */
    public function getChildren();

    /**
     * Add Post to Category.
     *
     * @param PostInterface $post
     */
    public function addPost(PostInterface $post);

    /**
     * Remove Post from Category.
     *
     * @param PostInterface $post
     */
    public function removePost(PostInterface $post);

    /**
     * Get all posts.
     *
     * @return PostInterface[]|ArrayCollection $posts
     */
    public function getPosts();

    /**
     * Get published posts.
     *
     * @return PostInterface[]|ArrayCollection $posts
     */
    public function getPublishedPosts();

    /**
     * Get total posts in Category currently.
     *
     * @return int $total
     */
    public function getTotal();

    /**
     * Whether category is root or not.
     *
     * @return bool
     */
    public function getRoot();
}
