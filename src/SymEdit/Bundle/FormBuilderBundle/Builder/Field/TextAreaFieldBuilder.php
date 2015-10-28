<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Builder\Field;

use Symfony\Component\Form\FormBuilderInterface;

class TextAreaFieldBuilder extends AbstractFieldBuilder
{
    public function buildOptionsForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('rows', 'integer', array(
                'property_path' => '[attr][rows]',
                'data' => 3,
            ))
        ;
    }

    public function getParent()
    {
        return 'text';
    }
}
