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

class AttributeLengthAnalyzer implements AnalyzerInterface
{
    public static $maxLength = [
        'title' => 65,
        'description' => 155,
    ];

    public static $minLength = [
        'title' => 25,
        'description' => 50,
    ];

    public function analyze(SeoAbleInterface $object, AnalyzerContext $context)
    {
        $seo = $object->getSeo();

        // Check Max Lengths
        foreach (self::$maxLength as $attribute => $size) {
            if (!isset($seo[$attribute])) {
                continue;
            }

            if (strlen($seo[$attribute]) > $size) {
                $context->addIssue(sprintf(
                    '"%s" attribute is too long. %d recommended maximum.',
                    $attribute,
                    $size
                ));
            }
        }

        // Check Min Lengths
        foreach (self::$minLength as $attribute => $size) {
            if (!isset($seo[$attribute])) {
                continue;
            }

            if (strlen($seo[$attribute]) < $size) {
                $context->addIssue(sprintf(
                    '"%s" attribute is too short. %d recommended minimum',
                    $attribute,
                    $size
                ));
            }
        }
    }
}
