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

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\MediaBundle\Form\DataTransformer\GalleryChooseDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageGalleryChooseType extends AbstractType
{
    protected $imageRepository;
    protected $itemRepository;

    public function __construct(RepositoryInterface $imageRepository, RepositoryInterface $itemRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->itemRepository = $itemRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new GalleryChooseDataTransformer($this->imageRepository, $this->itemRepository));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array();
        $labels = array();

        foreach ($this->imageRepository->findAll() as $image) {
            $choices[] = $image;
            $labels[] = $image->getName();
        }

        $resolver->setDefaults(array(
            'expanded' => true,
            'multiple' => true,
            'choice_list' => new ObjectChoiceList($choices, 'name'),
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'symedit_image_gallery_choose';
    }
}
