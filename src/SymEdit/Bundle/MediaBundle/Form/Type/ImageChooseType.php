<?php

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use SymEdit\Bundle\MediaBundle\Form\DataTransformer\GalleryChooseDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageChooseType extends AbstractType
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
        foreach ($this->imageRepository->findAll() as $image) {
            $builder->add(sprintf('image_%d', $image->getId()), new ImageChooseItemType($image));
        }

        $builder->addModelTransformer(new GalleryChooseDataTransformer($this->imageRepository, $this->itemRepository));
    }

    public function getName()
    {
        return 'symedit_image_choose';
    }
}