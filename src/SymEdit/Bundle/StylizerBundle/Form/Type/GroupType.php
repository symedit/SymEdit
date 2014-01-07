<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Form\Type; 

use Symfony\Component\Form\AbstractType; 
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 
use Symfony\Component\Form\FormView; 
use Symfony\Component\Form\FormInterface; 

class GroupType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['extra'] = $options['extra']; 
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'extra' => array(), 
            'virtual' => true, 
        )); 
    }
    
    public function getName()
    {
        return 'symedit_stylizer_grouptype'; 
    }    
    
    public function getParent()
    {
        return 'form'; 
    }
}