<?php

namespace SymEdit\Bundle\ThemeBundle\Model;

class Theme
{
    protected $name;
    protected $title;
    protected $description;
    protected $themeDirectory;
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
        return $this->themeDirectory;
    }

    public function getTemplateDirectory()
    {
        return sprintf('%s/%s', $this->getThemeDirectory(), 'templates');
    }

    public function setThemeDirectory($themeDirectory)
    {
        $this->themeDirectory = $themeDirectory;
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