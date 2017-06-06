<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\MediaBundle\Form\DataTransformer\GalleryChooseDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageGalleryChooseType extends AbstractType
{
    private $imageRepository;
    private $itemFactory;

    public function __construct(RepositoryInterface $imageRepository, FactoryInterface $itemFactory)
    {
        $this->imageRepository = $imageRepository;
        $this->itemFactory = $itemFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new GalleryChooseDataTransformer($this->itemFactory));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = [];
        $labels = [];

        foreach ($this->imageRepository->findAll() as $image) {
            $choices[$image->getName()] = $image;
        }

        $resolver->setDefaults([
            'expanded' => true,
            'multiple' => true,
            'choices' => $choices,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'symedit_image_gallery_choose';
    }
}
