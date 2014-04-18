<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;

class GoogleMapStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        try {
            $address = $widget->getOption('address');

            $content = $this->render('@SymEdit/CMS/map.html.twig', array(
                'query' => empty($address) ? null : $address,
            ));
        } catch (\Exception $e) {
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
                'help_block' => 'Leave blank for default company address',
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
        return 'core.google_map';
    }
}
