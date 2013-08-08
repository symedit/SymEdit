<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class GoogleMapStrategy extends AbstractWidgetStrategy
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function execute(WidgetInterface $widget)
    {
        try {
            $address = $widget->getOption('address');

            $content = $this->twig->render('@SymEdit/CMS/map.html.twig', array(
                'query' => empty($address) ? null : $address,
            ));
        } catch(\Exception $e){
            $content = sprintf('There was an error rendering your template: "%s"', $e->getMessage());
        }

        return $content;
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('address', 'textarea', array(
                'required' => false,
                'label' => 'Address',
                'property_path' => 'options[address]',
                'help_inline' => 'Leave blank for default company address',
                'attr' => array(
                    'rows' => 5,
                    'cols' => 50,
                ),
            ));
    }

    public function getName()
    {
        return 'google_map';
    }

    public function getDescription()
    {
        return 'Google Map';
    }
}