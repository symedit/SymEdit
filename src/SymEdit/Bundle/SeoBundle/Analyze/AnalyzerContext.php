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

class AnalyzerContext
{
    protected $object;
    protected $issues = [];

    public function __construct(SeoAbleInterface $object)
    {
        $this->object = $object;
    }

    public function addIssue($issue)
    {
        $this->issues[] = $issue;
    }

    public function getIssues()
    {
        return $this->issues;
    }

    public function hasIssues()
    {
        return count($this->issues) > 0;
    }

    public function getObject()
    {
        return $this->object;
    }
}
