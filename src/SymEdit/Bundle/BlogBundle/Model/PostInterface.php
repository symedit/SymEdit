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

use Symfony\Component\Security\Core\User\UserInterface;

interface PostInterface
{
    const DRAFT = 0;
    const PUBLISHED = 1;

    /**
     * Get Post ID.
     *
     * @return int
     */
    public function getId();

    /**
     * Set Post Title.
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * Get Post Title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Post Slug.
     *
     * @param string $slug
     */
    public function setSlug($slug);

    /**
     * Get Post Slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set Post Content.
     *
     * @param string $content
     */
    public function setContent($content);

    /**
     * Get Post Content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set Post Author.
     *
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author = null);

    /**
     * Get Post Author.
     *
     * @return UserInterface
     */
    public function getAuthor();

    public function setCreatedAt($createdAt);
    public function getCreatedAt();

    public function setPublishedAt($publishedAt);
    public function getPublishedAt();

    public function setSummary($summary);
    public function getSummary();

    public function setStatus($status);
    public function getStatus();

    public function addCategory(CategoryInterface $category);
    public function removeCategory(CategoryInterface $category);
    public function getCategories();

    public function isPublished();
}
