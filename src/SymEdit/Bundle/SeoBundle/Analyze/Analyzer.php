<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Analyze;

use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

class Analyzer
{
    protected $analyzers;

    public function __construct(array $analyzers)
    {
        $this->analyzers = $analyzers;
    }

    /**
     * @param SeoAbleInterface $object
     *
     * @return AnalyzerContext
     */
    public function analyze(SeoAbleInterface $object)
    {
        $context = new AnalyzerContext($object);

        foreach ($this->analyzers as $analyzer) {
            $analyzer->analyze($object, $context);
        }

        return $context;
    }
}
