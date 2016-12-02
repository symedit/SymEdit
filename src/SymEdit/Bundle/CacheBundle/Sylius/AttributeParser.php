<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\Sylius;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class AttributeParser
{
    private $accessor;

    public function process(array $attributes, $resource)
    {
        $processed = [];

        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $value = $this->process($value, $resource);
            }

            if (is_string($value) && strpos($value, 'resource.') === 0) {
                $value = $this->getAccessor()->getValue($resource, substr($value, 9));
            }

            $processed[$key] = $value;
        }

        return $processed;
    }

    /**
     * @return PropertyAccessor
     */
    private function getAccessor()
    {
        if ($this->accessor === null) {
            $this->accessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->accessor;
    }
}
