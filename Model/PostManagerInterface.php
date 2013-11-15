<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface PostManagerInterface
{
    /**
     * Creates a post
     *
     * @return PostInterface $post
     */
    public function createPost();

    /**
     * Removes a post
     */
    public function deletePost(PostInterface $post);

    /**
     * Enables status filter, so drafts won't appear
     */
    public function enableStatusFilter();

    /**
     * Disables status filter, so drafts will appear
     */
    public function disableStatusFilter();

    /**
     * Find by primary key
     *
     * @return PostInterface $post
     */
    public function find($id);

    /*
     * Finds all posts
     *
     * @return PostInterface
     */
    public function findAll();

    /**
     * @return PostInterface
     */
    public function findPostsBy(array $criteria);

    /**
     * @return PostInterface
     */
    public function findPostBy(array $criteria);

    /**
     * @return PostInterface
     */
    public function findPostBySlug($slug);

    /**
     * @return PostInterface
     */
    public function findRecentPosts($max = 3);

    /**
     * @return PostInterface
     */
    public function findPopular($max = null);

    /**
     * Get the current post class
     *
     * @return PostInterface $post
     */
    public function getClass();

    /**
     * Updates a post, will flush by default
     */
    public function updatePost(PostInterface $post, $andFlush = true);
}