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

use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface PostInterface extends ResourceInterface
{
    const DRAFT = 0;
    const PUBLISHED = 1;
    const SCHEDULED = 2;

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

    /**
     * Set created at.
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get Created at.
     *
     * @return \DateTime Get date created.
     */
    public function getCreatedAt();

    /**
     * Set Updated at.
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return \DateTime Date and time last updated.
     */
    public function getUpdatedAt();

    /**
     * Set Published At.
     *
     * @param \DateTime $publishedAt
     */
    public function setPublishedAt(\DateTime $publishedAt);

    /**
     * Get Published At.
     *
     * @return \DateTime Get published at date.
     */
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
