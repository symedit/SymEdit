<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface SeoInterface
{    
    /**
     * Merge other SEO into this one
     * 
     * @param array $values
     * @param boolean $mergeEmpty Whether or not to merge if merge values are empty
     */
    public function merge(array $values = array(), $mergeEmpty = false);
    
    /**
     * Gets title
     * 
     * @return string
     */
    public function getTitle();
    
    /**
     * Sets title
     * 
     * @param string $title
     * @return SeoInterface
     */
    public function setTitle($title);  

    /**
     * Gets description
     * 
     * @return string
     */
    public function getDescription();
    
    /**
     * Sets description
     * 
     * @param string $description
     * @return SeoInterface
     */
    public function setDescription($description); 

    /**
     * Get Keywords
     * 
     * @return string
     */
    public function getKeywords();

    /**
     * Set Keywords
     * 
     * @param string $keywords
     * @return SeoInterface
     */
    public function setKeywords($keywords);
    
    /**
     * Get Index
     * 
     * @return boolean
     */
    public function getIndex();

    /**
     * Set Index
     * 
     * @param boolean $index
     * @return SeoInterface
     */
    public function setIndex($index);
        
    /**
     * Set follow
     * 
     * @param boolean $follow
     * @return SeoInterface
     */
    public function setFollow($follow);
    
    /**
     * Get follow
     * 
     * @return boolean
     */
    public function getFollow();
}