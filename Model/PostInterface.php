<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

interface PostInterface extends SeoInterface
{
    public function getId();

    public function setTitle($title);
    public function getTitle();

    public function setSlug($slug);
    public function getSlug();
            
    public function setContent($content);
    public function getContent();

    public function setAuthor(UserInterface $author = null);
    public function getAuthor();

    public function setImage(MediaInterface $image = null);
    public function getImage();

    public function setCreatedAt($createdAt);
    public function getCreatedAt();

    public function setSummary($summary);
    public function getSummary();

    public function setStatus($status);
    public function getStatus();

    public function addCategory(CategoryInterface $category);
    public function removeCategory(CategoryInterface $category);
    public function getCategories();

    public function isPublished();
}