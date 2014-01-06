<?php

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DisqusStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render('@SymEdit/Widget/disqus.html.twig', array(
            'shortname' => $widget->getOption('shortname'),
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('shortname', 'text', array(
                'required' => true,
                'label' => 'Shortname',
                'constraints' => array(
                    new NotBlank(),
                ),
            ));
    }

    public function getName()
    {
        return 'disqus';
    }

    public function getDescription()
    {
        return 'Disqus Comments';
    }
}
