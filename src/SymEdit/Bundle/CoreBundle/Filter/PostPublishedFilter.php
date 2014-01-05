<?php

namespace SymEdit\Bundle\CoreBundle\Filter;

use Doctrine\ORM\Query\Filter\SQLFilter;
use SymEdit\Bundle\BlogBundle\Model\Post;
use Doctrine\ORM\Mapping\ClassMetadata;

class PostPublishedFilter extends SQLFilter
{
    private $postClass = 'Isometriks\\Bundle\\SymEditBundle\\Model\\Post';

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$targetEntity->reflClass->isSubclassOf($this->postClass)) {
            return '';
        }

        return $targetTableAlias . '.status = ' . Post::PUBLISHED;
    }
}