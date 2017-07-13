<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ZfrMailChimp\Client\MailChimpClient;

class ListType extends AbstractType
{
    protected $client;

    public function __construct(MailChimpClient $client)
    {
        $this->client = $client;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $choices = [];

        try {
            $lists = $this->client->getLists();

            foreach ($lists['data'] as $list) {
                $choices[$list['id']] = $list['name'];
            }

            $resolver->setDefaults([
                'choices' => $choices,
            ]);
        } catch (\Exception $e) {
            $resolver->setDefaults([
                'disabled' => true,
                'help_block' => 'Invalid API Key, cannot choose a list.',
            ]);
        }
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'mailchimp_list';
    }
}
