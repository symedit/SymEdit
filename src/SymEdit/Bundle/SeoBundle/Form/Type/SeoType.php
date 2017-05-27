<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'symedit.form.seo.title',
                'attr' => ['data-toggle' => 'char-count', 'data-max' => 65],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'symedit.form.seo.description',
                'attr' => ['data-toggle' => 'char-count', 'data-max' => 155],
                'required' => false,
            ])
            ->add('keywords', TextareaType::class, [
                'label' => 'symedit.form.seo.keywords',
                'required' => false,
            ])
            ->add('index', ChoiceType::class, [
                'choices' => [
                    'Index' => true,
                    'No Index' => false,
                ],
                'label' => 'symedit.form.seo.index',
            ])
            ->add('follow', ChoiceType::class, [
                'choices' => [
                    'Follow' => true,
                    'No Follow' => false,
                ],
                'label' => 'symedit.form.seo.follow',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label_render' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'symedit_seo';
    }
}
