<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Widget\Strategy\TemplateStrategy;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactInfoStrategy extends TemplateStrategy
{
    /**
     * Return just the regular form, you can't change the template.
     */
    public function buildForm(FormBuilderInterface $builder)
    {
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => '@SymEdit/Widget/contact-info.html.twig',
        ));
    }

    public function getName()
    {
        return 'contact_info';
    }

    public function getDescription()
    {
        return 'core.contact_info';
    }
}
