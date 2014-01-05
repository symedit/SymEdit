<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Model\Post;
use SymEdit\Bundle\CoreBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;

class RecentPostsStrategy extends AbstractWidgetStrategy
{
    private $postRepository;

    public function __construct(RepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $criteria = array(
            'status' => Post::PUBLISHED,
        );

        $sorting = array(
            'createdAt' => 'DESC',
        );

        $posts = $this->postRepository->findBy($criteria, $sorting, $widget->getOption('max'));

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
