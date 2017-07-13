<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ColorType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type'] = 'color';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $patterns = [
            '\#[a-f0-9]{3,6}',
            'rgb\(\d{1,3},\d{1,3},\d{1,3}\)',
            'rgba\(\d{1,3},\d{1,3},\d{1,3},0?\.\d{1,2}\)',
        ];

        $pattern = '/'.implode('|', $patterns).'/i';
        $regex = new Regex([
            'pattern' => $pattern,
        ]);

        // Stylizer adds NotBlank and overrides this.
        $resolver->setNormalizer('constraints', function (Options $options, $value) use ($regex) {
            $value[] = $regex;

            return $value;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'color';
    }
}
