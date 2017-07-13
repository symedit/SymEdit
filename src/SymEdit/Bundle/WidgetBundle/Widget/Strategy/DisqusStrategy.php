<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DisqusStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render($widget, [
            'shortname' => $widget->getOption('shortname'),
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('shortname', TextType::class, [
                'required' => true,
                'label' => 'Shortname',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SymEdit/Widget/disqus.html.twig',
        ]);
    }

    public function getName()
    {
        return 'disqus';
    }

    public function getDescription()
    {
        return 'widget.disqus';
    }
}
