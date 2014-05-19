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

class Theme implements ThemeInterface
{
    protected $name;
    protected $title;
    protected $description;
    protected $directory;
    protected $publicDirectory;
    protected $stylesheets;
    protected $javascripts;

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

    public function getTemplateDirectory()
    {
        return sprintf('%s/%s', $this->getThemeDirectory(), 'templates');
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
}
