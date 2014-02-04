<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Command;

use Symfony\Bundle\AsseticBundle\Command\DumpCommand as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $theme = $this->getContainer()->get('symedit_theme.theme');

        print_r($theme); die();

        $cssFormula = array(
            $theme->getStylesheets(),
            array(),
            array(
                'output' => $theme->getPublicDirectory().'/styles.css',
            ),
        );

        $jsFormula = array(
            $theme->getJavascripts(),
            array(),
            array(
                'output' => $theme->getPublicDirectory().'/scripts.js',
            ),
        );

        $am = $this->getContainer()->get('assetic.asset_manager');

        $am->setFormula('theme_css', $cssFormula);
        $am->setFormula('theme_js', $jsFormula);

        parent::execute($input, $output);
    }
}