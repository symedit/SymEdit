<?php

namespace Isometriks\Bundle\SymEditBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;

class RepositoryTransformer implements DataTransformerInterface
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Convert to database value
     *
     * @param type $value
     * @return type
     */
    public function reverseTransform($value)
    {
        return $this->repository->find($value);
    }

    /**
     * Convert to form value
     *
     * @param type $value
     */
    public function transform($value)
    {
        if ($value === null) {
            return null;
        }

        return $value->getId();
    }
}