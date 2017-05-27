<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends AbstractType
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class,
            'require_name' => true,
            'required' => true,
            'label' => 'File',
            'name_label' => 'File Name',
        ]);
    }

    public function getParent()
    {
        return MediaType::class;
    }

    public function getBlockPrefix()
    {
        return 'symedit_file';
    }
}
