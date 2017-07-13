<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\DataTransformer;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;

class RepositoryTransformer implements DataTransformerInterface
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Convert to database value.
     *
     * @param type $value
     *
     * @return type
     */
    public function reverseTransform($value)
    {
        return $this->repository->find($value);
    }

    /**
     * Convert to form value.
     *
     * @param type $value
     */
    public function transform($value)
    {
        if ($value === null) {
            return;
        }

        return $value->getId();
    }
}
