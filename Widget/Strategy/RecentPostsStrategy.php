<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\PostManagerInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class RecentPostsStrategy extends AbstractWidgetStrategy
{
    private $postManager;

    public function __construct(PostManagerInterface $postManager)
    {
        $this->postManager = $postManager;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $posts = $this->postManager->findRecentPosts($widget->getOption('max'));

        return $this->render('@SymEdit/Widget/blog-recent-posts.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('max', 'integer', array(
                'label' => 'Max Posts',
                'help_block' => 'Maximum Posts to display in Widget',
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