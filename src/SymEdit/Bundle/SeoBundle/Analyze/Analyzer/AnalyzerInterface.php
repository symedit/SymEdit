<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Analyze\Analyzer;

use SymEdit\Bundle\SeoBundle\Analyze\AnalyzerContext;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

interface AnalyzerInterface
{
    public function analyze(SeoAbleInterface $object, AnalyzerContext $context);
}
