<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DebugCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('symedit:stylizer:debug')
            ->setDescription('Show all stylizer variables')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = $this->getHelper('table');
        $styles = $this->getContainer()->get('symedit_stylizer.styles');

        $table->setHeaders(array('Name', 'Value'));

        foreach ($styles->getVariables() as $name => $value) {
            $table->addRow(array($name, $value));
        }

        $table->render($output);
    }
}
