<?php

namespace SymEdit\Bundle\MailChimpBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\FormBuilderInterface;
use ZfrMailChimp\Client\MailChimpClient;

class SubscribeStrategy extends AbstractWidgetStrategy
{
    protected $client;

    public function __construct(MailChimpClient $client)
    {
        $this->client = $client;
    }

    public function execute(WidgetInterface $widget)
    {
        $list = $this->getList($widget->getOption('list'));

        return $this->render('@SymEdit/Widget/MailChimp/subscribe-form.html.twig', array(
            'list' => $list,
            'placeholder' => $widget->getOption('placeholder'),
            'button_text' => $widget->getOption('button_text'),
        ));
    }

    protected function getList($listName)
    {
        try {
            $response = $this->client->getLists();
        } catch (Exception $ex) {
            return false;
        }

        foreach ($response['data'] as $list) {
            if ($list['name'] === $listName) {
                return $list;
            }
        }

        return false;
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'placeholder' => 'you@email.com',
            'button_text' => 'Subscribe!',
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('list', 'mailchimp_list')
            ->add('placeholder', 'text')
            ->add('button_text', 'text')
        ;
    }

    public function getDescription()
    {
        return 'MailChimp Subscribe';
    }

    public function getName()
    {
        return 'mailchimp_subscribe';
    }
}