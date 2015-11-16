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

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use SymEdit\Bundle\CoreBundle\Form\DataTransformer\RepositoryTransformer;
use SymEdit\Bundle\CoreBundle\Repository\PageRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageChooseType extends AbstractType
{
    protected $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
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
        return ChoiceType::class;
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
