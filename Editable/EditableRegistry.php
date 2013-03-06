<?php

namespace Isometriks\Bundle\SymEditBundle\Editable;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Isometriks\Bundle\SymEditBundle\Editable\Exception\UnsupportedExtensionException;

class EditableRegistry
{
    private $extensions;

    public function __construct(ContainerInterface $container, array $extensions = array())
    {
        $this->container = $container;
        $this->extensions = $extensions;
    }

    /**
     * Get all extensions. Keep in mind some of these extensions might
     * not be loaded yet and will just contain a string to its ID in the
     * container
     * 
     * @return array Array of EditableExtensionInterface|string
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Returns all loaded extensions. This is used by the Twig extension
     * to only load stylesheets / javascript from the extensions that got
     * used in the current page only to prevent extra load. 
     * 
     * @return array Array of EditableExtensionInterface
     */
    public function getLoadedExtensions()
    {
        $extensions = array();
        foreach ($this->extensions as $key => $extension) {
            if (!is_string($extension)) {
                $extensions[] = $extension;
            }
        }

        return $extensions;
    }

    /**
     * Try to find 
     * 
     * @param \Isometriks\Bundle\SymEditBundle\Editable\Editable $editable
     * @return EditableExtensionInterface
     * @throws UnsupportedExtensionException
     */
    public function getExtensionForType(Editable $editable)
    {
        foreach ($this->extensions as $key => &$extension) {
            if (is_string($extension)) {
                $extension = $this->container->get($extension);
                $extension->setTemplating($this->container->get('templating'));
            }

            if ($extension->supports($editable)) {
                return $extension;
            }
        }

        throw new UnsupportedExtensionException($editable, sprintf('Unable to find extension for type "%s"', $editable->getType()));
    }
}