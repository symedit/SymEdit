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

use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

interface PageInterface extends SeoAbleInterface, \IteratorAggregate
{
    /**
     * @return mixed Unique ID for Page
     */
    public function getId();

    /**
     * @param bool $homepage
     */
    public function setHomepage($homepage);

    /**
     * @return bool Whether the page is the homepage
     */
    public function getHomepage();

    /**
     * @param bool $root
     */
    public function setRoot($root);

    /**
     * @return bool Whether the page is the root node
     */
    public function getRoot();

    /**
     * Gets the root node.
     *
     * @return PageInterface
     */
    public function getRootNode();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string Page name
     */
    public function getName();

    /**
     * @param string $tagline
     */
    public function setTagline($tagline);

    /**
     * @return string The page tagline
     */
    public function getTagline();

    /**
     * @param string $summary
     */
    public function setSummary($summary);

    /**
     * @return string The page summary
     */
    public function getSummary();

    /**
     * @return \DateTime $createdAt
     */
    public function getCreatedAt();

    /**
     * @return string $createdBy
     */
    public function getCreatedBy();

    /**
     * @param \DateTime $time
     *
     * @return PageInterface
     */
    public function setUpdatedAt($time);

    /**
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt();

    /**
     * @return string $updatedBy
     */
    public function getUpdatedBy();

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return string Page title
     */
    public function getTitle();

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @return string Page content
     */
    public function getContent();

    /**
     * Set Display Options.
     *
     * @param array $displayOptions
     */
    public function setDisplayOptions(array $displayOptions);

    /**
     * @return array Display Options.
     */
    public function getDisplayOptions();

    /**
     * @param int $pageOrder
     */
    public function setPageOrder($pageOrder);

    /**
     * @return int Page's level
     */
    public function getLevel();

    /**
     * @return int Page order
     */
    public function getPageOrder();

    /**
     * @param bool $display
     */
    public function setDisplay($display);

    /**
     * @return bool Whether to display the page or not
     */
    public function getDisplay();

    /**
     * @return ImageInterface
     */
    public function getImage();

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image);

    /**
     * @param bool $crawl
     */
    public function setCrawl($crawl);

    /**
     * @return bool Whether or not to put page on sitemap
     */
    public function getCrawl();

    /**
     * @param bool $pageController
     */
    public function setPageController($pageController);

    /**
     * @return bool Whether page is tied to a controller or not
     */
    public function getPageController();

    public function setPageControllerPath($pageControllerPath);

    public function getPageControllerPath();

    /**
     * Set Page's path.
     *
     * @param string $path
     *
     * @return PageInterface $page
     */
    public function setPath($path);

    /**
     * Gets the page's path.
     *
     * @return string $path
     */
    public function getPath();

    public function setParent(PageInterface $parent = null);

    public function getParent();

    public function addChildren(PageInterface $children);

    public function removeChildren(PageInterface $children);

    public function getChildren();

    public function setTemplate($template);

    public function getTemplate();

    public function setActive($active, $traverse = false);

    public function getActive();

    public function getVisibleChildren();

    public function getRoute();

    public function isNameValid(ExecutionContextInterface $context);
}
