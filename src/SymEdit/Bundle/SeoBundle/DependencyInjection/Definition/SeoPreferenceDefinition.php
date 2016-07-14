<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\DependencyInjection\Definition;

class SeoPreferenceDefinition extends \Symfony\Component\DependencyInjection\Definition
{
    public function __construct($model, array $title, array $description)
    {
        parent::__construct('%symedit_seo.model.preference.class%', [$model, $title, $description]);
    }
}
