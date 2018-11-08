<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use SymEdit\Bundle\BlogBundle\Form\Type\PostType as BasePostType;
use SymEdit\Bundle\MediaBundle\Form\Type\ImageChooseType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends BasePostType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('image', ImageChooseType::class, [
                'required' => false,
                'show_image' => true,
                'label' => 'symedit.form.post.image',
            ])
        ;
    }
}
