<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Doctrine\Bundle\DoctrineBundle\Registry; 
use Symfony\Component\Validator\Constraints\Range; 

class RecentPostsStrategy extends AbstractWidgetStrategy
{
    private $twig; 
    private $doctrine; 
    private $host_bundle; 
    
    public function __construct(\Twig_Environment $twig, Registry $doctrine, $host_bundle)
    {
        $this->twig = $twig; 
        $this->doctrine = $doctrine; 
        $this->host_bundle = $host_bundle; 
    }

    public function execute(WidgetInterface $widget)
    {
        $posts = $this->doctrine->getManager()->getRepository('IsometriksSymEditBundle:Post')->getRecent($widget->getOption('max')); 
        
        return $this->twig->render($this->host_bundle . ':Widget:blog-recent-posts.html.twig', array(
            'posts' => $posts, 
        )); 
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('max', 'integer', array(
                'label' => 'Max Posts', 
                'help_block' => 'Maximum Posts to display in Widget', 
                'property_path' => 'options[max]', 
                'constraints' => array(
                    new Range(array(
                        'min' => 1, 
                        'minMessage' => 'Minimum posts is 1, if you want less disable the widget.', 
                    )),
                ), 
            )); 
    }    
    
    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'max' => 3, 
        )); 
    }
    
    public function getName()
    {
        return 'blog_recent_posts'; 
    }

    public function getDescription()
    {
        return 'Recent Posts'; 
    }
}