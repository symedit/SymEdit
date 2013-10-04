<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class TemplateStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        try {
            $content = $this->render($widget->getOption('template'));
        } catch(\Exception $e){
            $content = sprintf('There was an error rendering your template: "%s"', $e->getMessage());
        }

        return $content;
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('template', 'text', array(
                'required' => true,
                'label' => 'Template',
                'constraints' => array(
                    new NotBlank(),
                ),
            ));
    }

    public function getName()
    {
        return 'template';
    }

    public function getDescription()
    {
        return 'Template';
    }
}