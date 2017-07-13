<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use SymEdit\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use SymEdit\Bundle\SettingsBundle\Schema\SchemaRegistryInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Settings controller.
 */
class SettingsController extends FOSRestController
{
    public function updateAction(Request $request)
    {
        $form = $this->getForm($request);

        if ($form->handleRequest($request)->isValid()) {
            $this->saveFormData($form->getData());
        }

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Settings/index.html.twig')
            ->setData([
                'form' => $form->createView(),
            ])
        ;

        return $this->handleView($view);
    }

    protected function saveFormData(array $data)
    {
        $manager = $this->getSettingsManager();

        foreach ($data as $settings) {
            try {
                $manager->save($settings);
            } catch (\Exception $ex) {
                $this->addFlash('error', $ex->getMessage());

                break;
            }
        }

        $this->addFlash('success', 'symedit.settings.saved');
    }

    protected function getForm(Request $request, $resource = null)
    {
        $settings = $this->getSettingsManager();
        $schemas = $this->getSchemaRegistry()->all();
        $builder = $this->createFormBuilder()->create('sylius_settings', FormType::class);
        $data = [];

        foreach ($schemas as $namespace => $schema) {
            // Check roles
            if (!$this->isGranted($this->getNamespaceRole($namespace))) {
                continue;
            }

            $namespaceForm = $builder->create($namespace, FormType::class);
            $schema->buildForm($namespaceForm);
            $builder->add($namespaceForm);

            $data[$namespace] = $settings->load($namespace);
        }

        // Set all the data
        $builder->setData($data);

        return $builder->getForm();
    }

    protected function getNamespaceRole($namespace)
    {
        return sprintf('ROLE_ADMIN_SETTING_%s', strtoupper($namespace));
    }

    /**
     * Get settings manager.
     *
     * @return SettingsManagerInterface
     */
    protected function getSettingsManager()
    {
        return $this->get('symedit.settings_manager');
    }

    /**
     * Get Schema Registry.
     *
     * @return SchemaRegistryInterface
     */
    protected function getSchemaRegistry()
    {
        return $this->get('symedit.registry.settings_schema');
    }
}
