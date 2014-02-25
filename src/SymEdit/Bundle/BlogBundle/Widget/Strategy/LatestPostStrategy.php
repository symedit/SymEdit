<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Widget\Strategy;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\FormBuilderInterface;

class LatestPostStrategy extends AbstractWidgetStrategy
{
    private $postRepository;

    public function __construct(RepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(WidgetInterface $widget)
    {
        $post = $this->postRepository->getLatestPost();

        return $this->render('@SymEdit/Widget/Blog/latest-post.html.twig', array(
            'post' => $post,
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('show_image', 'checkbox', array(
                'label' => 'Show Image',
                'required' => false,
            ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'show_image' => true,
        ));
    }

    public function getName()
    {
        return 'blog_latest_post';
    }

    public function getDescription()
    {
        return 'Latest Blog Post';
    }
}
