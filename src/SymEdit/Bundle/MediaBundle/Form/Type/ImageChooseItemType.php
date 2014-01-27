<?php

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use SymEdit\Bundle\MediaBundle\Form\DataTransformer\GalleryItemDataTransformer;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ImageChooseItemType extends AbstractType
{
    protected $image;

    public function __construct(ImageInterface $image)
    {
        $this->image = $image;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new GalleryItemDataTransformer());
        $builder
            ->add('id', 'hidden', array(
                'data' => $this->image->getId(),
            ))
            ->add('selected', 'checkbox', array(
                'required' => false,
            ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['image'] = $this->image;
    }

    public function getName()
    {
        return 'symedit_image_choose_item';
    }
}