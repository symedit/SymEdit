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
use Doctrine\Common\Collections\Collection;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Post implements PostInterface
{
    const DRAFT = 0;
    const PUBLISHED = 1;

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var
     */
    protected $author;

    /**
     * @var ImageInterface
     */
    protected $image;

    /**
     * @var string $slug
     */
    protected $slug;

    /**
     * @var string $content
     */
    protected $content;

    /**
     * @var string $summary
     */
    protected $summary;

    /**
     * @var \DateTime $createdAt
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var \DateTime $publishedAt
     */
    protected $publishedAt;

    /**
     * @var ArrayCollection $categories
     */
    protected $categories;

    /**
     * @var integer $status
     */
    protected $status;

    /**
     * @var array $seo
     */
    protected $seo;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->setStatus(self::DRAFT);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set content
     *
     * @param  string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author
     *
     * @param  UserInterface $author
     * @return Post
     */
    public function setAuthor(UserInterface $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }

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

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add categories
     *
     * @param  CategoryInterface $categories
     * @return Post
     */
    public function addCategory(CategoryInterface $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param CategoryInterface $categories
     */
    public function removeCategory(CategoryInterface $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set seo
     *
     * @param  array $seo
     * @return Post
     */
    public function setSeo(array $seo = array())
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return array
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Set summary
     *
     * @param  string $summary
     * @return Post
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set status
     *
     * @param  integer $status
     * @return Post
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Whether the post is published or not
     *
     * @return boolean
     */
    public function isPublished()
    {
        return $this->status === self::PUBLISHED;
    }
}
