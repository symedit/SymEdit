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
use Sylius\Bundle\SettingsBundle\Transformer\ResourceToIdentifierTransformer;
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
            ->add('logo', 'symedit_image_choose', [
                'label' => 'symedit.settings.company.logo',
                'required' => false,
            ])
            ->add('name', null, [
                'label' => 'symedit.settings.company.name',
                'required' => false,
            ])
            ->add('address', 'textarea', [
                'label' => 'symedit.settings.company.address',
                'required' => false,
            ])
            ->add('email', 'email', [
                'label' => 'symedit.settings.company.email',
            ])
            ->add('phone', null, [
                'label' => 'symedit.settings.company.phone',
                'required' => false,
            ])
            ->add('fax', null, [
                'label' => 'symedit.settings.company.fax',
                'required' => false,
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'logo' => null,
                'name' => 'SymEdit Site',
                'address' => '5 SymEdit Way',
                'email' => 'contact@mysite.com',
                'phone' => '(123)-123-1234',
                'fax' => '',
            ])
            ->setAllowedTypes([
                'logo' => ['null', 'SymEdit\Bundle\MediaBundle\Model\ImageInterface'],
                'name' => ['string', 'null'],
                'address' => ['string', 'null'],
                'email' => ['string'],
                'phone' => ['string', 'null'],
                'fax' => ['string', 'null'],
            ])
            ->setTransformer('logo', new ResourceToIdentifierTransformer($this->imageRepository))
        ;
    }
}
