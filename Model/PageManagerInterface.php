<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface PageManagerInterface
{
    public function createPage();

    public function deletePage(PageInterface $page);

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

    public function getClass();

    public function updatePage(PageInterface $page, $andFlush = true);
}