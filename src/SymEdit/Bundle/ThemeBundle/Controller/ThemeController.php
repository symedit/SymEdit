<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Controller;

use SymEdit\Bundle\ThemeBundle\Theme\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThemeController extends Controller
{
    public function indexAction()
    {
        $themes = $this->getThemeManager()->getThemes();

        return $this->render('@SymEdit/Admin/Theme/index.html.twig', [
            'themes' => $themes,
        ]);
    }

    /**
     * @return ThemeManager
     */
    protected function getThemeManager()
    {
        return $this->get('symedit_theme.theme_manager');
    }
}
