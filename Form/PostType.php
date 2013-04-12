<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Isometriks\Bundle\SymEditBundle\Entity\Post; 

class PostType extends AbstractType {

    private $userClass; 
    
    public function __construct($userClass)
    {
        $this->userClass = $userClass;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text', array(
                    'attr' => array(
                        'class' => 'span5', 
                    )
                ))
                ->add('content', 'textarea', array(
                    'attr' => array(
                        'class' => 'wysiwyg-editor',
                        'style' => 'height:500px',
                    ),
                    'required' => false,
                ))
                ->add('summary', 'textarea', array(
                    'attr' => array(
                        'class' => 'wysiwyg-editor', 
                        'style' => 'height:300px', 
                    ),
                    'required' => false, 
                ))
                ->add('author', 'entity', array(
                    'property' => 'fullname', 
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
                    'class'    => 'Isometriks\\Bundle\\SymEditBundle\\Entity\\Category',
                    'multiple' => true,
                    'expanded'  => true, 
                ))
                ->add('image', new ImageType(), array(
                    'require_name' => false, 
                    'required' => false, 
                ))
                ->add('seo', new SeoVirtualType())
        ;
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Entity\Post',
            'translation_domain' => 'SymEdit', 
        ));
    }

    public function getName()
    {
        return 'symedit_post';
    }

}
