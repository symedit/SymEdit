<?php

namespace Isometriks\Bundle\SymEditBundle\Filter;

use Doctrine\ORM\Query\Filter\SQLFilter;
use Isometriks\Bundle\SymEditBundle\Entity\Post;
use Doctrine\ORM\Mapping\ClassMetadata; 

class PostPublishedFilter extends SQLFilter
{
    private $postClass = 'Isometriks\\Bundle\\SymEditBundle\\Entity\\Post';

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->reflClass->name !== $this->postClass) {
            return '';
        }

        return $targetTableAlias . '.status = ' . Post::PUBLISHED;
    }
}