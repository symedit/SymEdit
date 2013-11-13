<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface PageManagerInterface
{
    /**
     * Creates a page
     *
     * @return PageInterface $page
     */
    public function createPage();

    /**
     * Removes a page
     */
    public function deletePage(PageInterface $page);

    /**
     * Find by primary key
     *
     * @return PageInterface $page
     */
    public function find($id);

    /**
     * @return PageInterface
     */
    public function findPagesBy(array $criteria);

    /**
     * @return PageInterface
     */
    public function findPageBy(array $criteria);

    /**
     * @return PageInterface
     */
    public function findRoot();

    /**
     * @return PageInterface
     */
    public function findPageByPath($path);

    /**
     * Get the current page class
     *
     * @return PageInterface $page
     */
    public function getClass();

    /**
     * Updates a page, will flush by default
     */
    public function updatePage(PageInterface $page, $andFlush = true);
    
    /**
     * Gets log entries
     * 
     * @return object|array
     */
    public function getLogEntries();
}