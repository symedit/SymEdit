<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Model\WidgetInterface;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class PopularPostsStrategy extends AbstractWidgetStrategy
{
    protected $postRepository;

    public function __construct(RepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $posts = $this->postRepository->findPopular($widget->getOption('max'));

        return $this->render('@SymEdit/Widget/blog-popular-posts.html.twig', array(
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
        return 'blog_popular_posts';
    }

    public function getDescription()
    {
        return 'Popular Posts';
    }
}
