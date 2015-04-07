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

interface ThemeInterface
{
    public function getName();

    public function setName($name);

    public function getTitle();

    public function setTitle($title);

    public function getDescription();

    public function setDescription($description);

    public function getStylesheets();

    public function setStylesheets($stylesheets);

    public function getJavascripts();

    public function setJavascripts($javascripts);

    public function getThemeDirectory();

    public function getTemplateDirectories($first = false);

    public function setDirectory($directory);

    public function getPublicDirectory();

    public function setPublicDirectory($publicDirectory);

    public function getParentTheme();

    public function setParentTheme(ThemeInterface $theme);
}
