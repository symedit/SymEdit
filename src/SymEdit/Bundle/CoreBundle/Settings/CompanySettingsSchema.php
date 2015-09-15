<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Settings;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Sylius\Bundle\SettingsBundle\Transformer\ObjectToIdentifierTransformer;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\FormBuilderInterface;

class CompanySettingsSchema implements SchemaInterface
{
    protected $imageRepository;

    public function __construct(RepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('logo', 'symedit_image_choose', array(
                'label' => 'symedit.settings.company.logo',
                'required' => false,
            ))
            ->add('name', null, array(
                'label' => 'symedit.settings.company.name',
                'required' => false,
            ))
            ->add('address', 'textarea', array(
                'label' => 'symedit.settings.company.address',
                'required' => false,
            ))
            ->add('email', 'email', array(
                'label' => 'symedit.settings.company.email',
            ))
            ->add('phone', null, array(
                'label' => 'symedit.settings.company.phone',
                'required' => false,
            ))
            ->add('fax', null, array(
                'label' => 'symedit.settings.company.fax',
                'required' => false,
            ))
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array(
                'logo' => null,
                'name' => 'SymEdit Site',
                'address' => '5 SymEdit Way',
                'email' => 'contact@mysite.com',
                'phone' => '(123)-123-1234',
                'fax' => '',
            ))
            ->setAllowedTypes(array(
                'logo' => array('null', 'SymEdit\Bundle\MediaBundle\Model\ImageInterface'),
                'name' => array('string', 'null'),
                'address' => array('string', 'null'),
                'email' => array('string'),
                'phone' => array('string', 'null'),
                'fax' => array('string', 'null'),
            ))
            ->setTransformer('logo', new ObjectToIdentifierTransformer($this->imageRepository))
        ;
    }
}
