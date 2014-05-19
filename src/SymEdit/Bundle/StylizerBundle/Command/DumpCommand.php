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

use Symfony\Bundle\AsseticBundle\Command\DumpCommand as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stylizer = $this->getContainer()->get('symedit_stylizer.stylizer');
        $stylizer->inject();

        parent::execute($input, $output);
    }
}
