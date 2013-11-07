<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

use Symfony\Component\Validator\ExecutionContextInterface;

interface PageInterface extends SeoAbleInterface, \IteratorAggregate
{
    /**
     * @return mixed Unique ID for Page
     */
    public function getId();

    /**
     * @param boolean $homepage
     */
    public function setHomepage($homepage);

    /**
     * @return boolean Whether the page is the homepage
     */
    public function getHomepage();

    /**
     * @param boolean $root
     */
    public function setRoot($root);

    /**
     * @return boolean Whether the page is the root node
     */
    public function getRoot();

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
     * @param \DateTime $time
     * @return PageInterface
     */
    public function setUpdatedAt($time); 
    
    /**
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt(); 
    
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
     * @param integer $pageOrder
     */
    public function setPageOrder($pageOrder);

    /**
     * @return integer Page's level
     */
    public function getLevel(); 
    
    /**
     * @return integer Page order
     */
    public function getPageOrder();

    /**
     * @param boolean $display
     */
    public function setDisplay($display);

    /**
     * @return boolean Whether to display the page or not
     */
    public function getDisplay();

    /**
     * @param boolean $crawl
     */
    public function setCrawl($crawl);

    /**
     * @return boolean Whether or not to put page on sitemap
     */
    public function getCrawl();

    /**
     * @param boolean $pageController
     */
    public function setPageController($pageController);

    /**
     * @return boolean Whether page is tied to a controller or not
     */
    public function getPageController();

    public function setPageControllerPath($pageControllerPath);

    public function getPageControllerPath();

    /**
     * Set Page's path
     * 
     * @param string $path
     * @return PageInterface $page
     */
    public function setPath($path);
    
    /**
     * Gets the page's path
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