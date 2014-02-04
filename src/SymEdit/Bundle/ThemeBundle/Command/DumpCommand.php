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
        $am = $this->getContainer()->get('assetic.asset_manager');

        $formula = array(
            array('themes/simple/styles/site.less'),
            array(),
            array(
                'output' => 'themes/simple/styles/output.css',
            ),
        );

        $am->setFormula('theme', $formula);

        die(print_r($am->getFormula('theme')));

        parent::execute($input, $output);
    }
}