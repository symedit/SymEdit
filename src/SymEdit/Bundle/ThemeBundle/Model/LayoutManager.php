<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Model;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;

class LayoutManager
{
    protected $loader;
    protected $configuration;
    protected $processor;
    protected $layouts = [];

    public function __construct(LoaderInterface $loader, ConfigurationInterface $configuration)
    {
        $this->loader = $loader;
        $this->configuration = $configuration;
    }

    public function getLayouts()
    {
        return $this->layouts;
    }

    /**
     * Get a layout for a template.
     *
     * @param TemplateInterface $template
     *
     * @return TemplateInterface|null
     */
    public function getLayout(TemplateInterface $template)
    {
        /*
         * Use array_key_exists instead of isset since we're using
         * null if a template doesn't get loaded and isset will try every time
         */
        if (!array_key_exists($template->getKey(), $this->layouts)) {
            $layout = $this->loadLayout($template);
            $this->layouts[$template->getKey()] = $layout;

            if ($layout !== null) {
                $template->setLayout($layout);
            }
        }

        return $this->layouts[$template->getKey()];
    }

    protected function loadLayout(TemplateInterface $template)
    {
        try {
            $layoutData = $this->loader->load($template->getPath());
        } catch (\Exception $e) {
            return $this->createLayout($template->getKey(), $template->getKey());
        }

        // Did we even find a layout?
        if ($layoutData === null) {
            return $this->createLayout($template->getKey(), $template->getKey());
        }

        try {
            $processed = $this->getProcessor()->processConfiguration($this->configuration, [
                [
                    'title' => $template->getKey(),
                ],
                $layoutData
            ]);
        } catch (InvalidConfigurationException $e) {
            return $this->createLayout($template->getKey());
        }

        return $this->createLayout($template->getKey(), $processed['title'], $processed['description'], $processed['layout']);
    }

    protected function createLayout($key, $title = null, $description = null, $layout = null)
    {
        return new Layout($key, $title, $description, $layout);
    }

    /**
     * @return Processor
     */
    protected function getProcessor()
    {
        if ($this->processor === null) {
            $this->processor = new Processor();
        }

        return $this->processor;
    }
}
