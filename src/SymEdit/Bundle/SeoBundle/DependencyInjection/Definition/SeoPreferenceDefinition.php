<?php

namespace SymEdit\Bundle\SeoBundle\DependencyInjection\Definition;

class SeoPreferenceDefinition extends \Symfony\Component\DependencyInjection\Definition
{
    public function __construct($model, array $title, array $description)
    {
        parent::__construct('%symedit_seo.model.preference.class%', array($model, $title, $description));
    }
}
