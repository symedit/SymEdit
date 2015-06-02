<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Form\DataTransformer\RepositoryTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageChooseType extends AbstractType
{
    protected $pageRepository;

    public function __construct(RepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new RepositoryTransformer($this->pageRepository)
        );
    }

    public function getParent()
    {
        return 'choice';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $root = $this->pageRepository->findRoot();
        $iterator = $this->pageRepository->getRecursiveIterator(false);

        $choices = array(
            $root->getId() => 'Root',
        );

        foreach ($iterator as $page) {
            if ($page->getHomepage()) {
                continue;
            }
            $choices[$page->getId()] = str_repeat('--', $page->getLevel()).' '.$page->getTitle();
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
        ));
    }

    public function getName()
    {
        return 'symedit_page_choose';
    }
}
