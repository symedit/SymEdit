<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Isometriks\Bundle\SymEditBundle\Model\Post;

class PostType extends AbstractType {

    private $userClass;

    public function __construct($userClass)
    {
        $this->userClass = $userClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'inherit_data' => true,
            'label' => 'Basic',
        ));

        $basic
            ->add('title', 'text', array(
                'attr' => array(
                    'class' => 'span5',
                )
            ))
            ->add('author', 'entity', array(
                'property' => 'profile.fullname',
                'class'    => $this->userClass,
            ))
            ->add('status', 'choice', array(
                'choices' => array(
                    Post::DRAFT => 'Draft',
                    Post::PUBLISHED => 'Published',
                ),
            ))
            ->add('categories', 'entity', array(
                'property' => 'title',
                'class'    => 'Isometriks\Bundle\SymEditBundle\Model\Category',
                'multiple' => true,
                'expanded'  => true,
            ))
            ->add('image', 'symedit_image', array(
                'require_name' => false,
                'required' => false,
                'label' => 'Featured Image',
            ));

        $seo = $builder->create('seo', 'tab', array(
            'inherit_data' => true,
            'label' => 'SEO',
        ));

        $seo
            ->add('seo', new SeoVirtualType());


        $summary = $builder->create('summary', 'tab', array(
            'inherit_data' => true,
            'label' => 'Summary',
        ));

        $summary
            ->add('summary', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:300px',
                ),
                'required' => false,
            ));


        $content = $builder->create('content', 'tab', array(
            'inherit_data' => true,
            'label' => 'Content',
        ));

        $content
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                ),
                'required' => false,
            ));

        $builder
            ->add($basic)
            ->add($seo)
            ->add($summary)
            ->add($content);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Model\Post',
            'translation_domain' => 'SymEdit',
        ));
    }

    public function getName()
    {
        return 'symedit_post';
    }

}
