<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\CoreBundle\DataFixtures\AbstractFixture;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;

class LoadFormBuilderData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $builder = $this->createForm()
            ->setName('main-contact-form')
            ->setLegend('Contact')
        ;

        $elements = array();
        $elements[] = $this->createFormElement()
            ->setName('name')
            ->setType('text')
            ->setOptions(array(
                'label' => 'Name',
                'required' => true,
            ))
        ;

        $elements[] = $this->createFormElement()
            ->setName('email')
            ->setType('email')
            ->setOptions(array(
                'label' => 'Email',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'you@email.com',
                ),
                'extra' => array(
                    'replyTo' => true,
                ),
            ))
        ;

        $elements[] = $this->createFormElement()
            ->setName('phone')
            ->setType('text')
            ->setOptions(array(
                'label' => 'Phone',
                'required' => true,
                'attr' => array(
                    'placeholder' => '123-123-1234',
                ),
            ))
        ;

        $elements[] = $this->createFormElement()
            ->setName('message')
            ->setType('textarea')
            ->setOptions(array(
                'label' => 'Message',
                'required' => true,
                'attr' => array(
                    'rows' => 3,
                ),
            ))
        ;

        // Add Elements
        array_map(array($builder, 'addFormElement'), $elements);

        // Save / flush
        $manager->persist($builder);
        $manager->flush();

        // Add Reference
        $this->addReference('form_builder-contact', $builder);
    }

    /**
     * @return FormElementInterface
     */
    protected function createFormElement()
    {
        return $this->getFactory('form_element')->createNew();
    }

    /**
     * @return FormInterface
     */
    protected function createForm()
    {
        return $this->getFactory('form_builder')->createNew();
    }

    public function getOrder()
    {
        return 25;
    }
}
