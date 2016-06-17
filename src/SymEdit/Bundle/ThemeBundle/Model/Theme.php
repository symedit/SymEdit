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

class Theme implements ThemeInterface, \Serializable
{
    protected $name;
    protected $title;
    protected $description;
    protected $directory;
    protected $publicDirectory;
    protected $stylesheets;
    protected $javascripts;
    protected $parent;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    public function setStylesheets($stylesheets)
    {
        $this->stylesheets = $stylesheets;

        return $this;
    }

    public function getJavascripts()
    {
        return $this->javascripts;
    }

    public function setJavascripts($javascripts)
    {
        $this->javascripts = $javascripts;

        return $this;
    }

    public function getThemeDirectory()
    {
        return sprintf('%s/%s', $this->directory, $this->getName());
    }

    public function getTemplateDirectories($first = false)
    {
        if ($first) {
            return $this->getTemplateDirectory();
        }

        $directories = [];
        $currentTheme = $this;

        while ($currentTheme !== null) {
            $directory = $currentTheme->getTemplateDirectory();
            $currentTheme = $currentTheme->getParentTheme();

            if (!is_dir($directory)) {
                continue;
            }

            $directories[] = $directory;
        }

        return $directories;
    }

    protected function getTemplateDirectory()
    {
        return $this->getDirectory('templates');
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    public function getPublicDirectory()
    {
        return $this->publicDirectory;
    }

    public function setPublicDirectory($publicDirectory)
    {
        $this->publicDirectory = $publicDirectory;

        return $this;
    }

    public function getParentTheme()
    {
        return $this->parent;
    }

    public function setParentTheme(ThemeInterface $theme)
    {
        $this->parent = $theme;

        return $this;
    }

    protected function getDirectory($name)
    {
        return sprintf('%s/%s', $this->getThemeDirectory(), $name);
    }

    public function serialize()
    {
        return serialize([
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'stylesheets' => $this->stylesheets,
            'javascripts' => $this->javascripts,
            'directory' => $this->directory,
            'publicDirectory' => $this->publicDirectory,
            'parent' => $this->parent,
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->name = $data['name'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->stylesheets = $data['stylesheets'];
        $this->javascripts = $data['javascripts'];
        $this->directory = $data['directory'];
        $this->publicDirectory = $data['publicDirectory'];
        $this->parent = $data['parent'];
    }
}
