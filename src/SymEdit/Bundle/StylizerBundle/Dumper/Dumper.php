<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Dumper;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;

class Dumper
{
    private $command;

    public function __construct(Command $command)
    {
        $this->command = $command;

        /**
         * Setup command
         */
        $definition = $this->command->getDefinition();
        $definition->addOption(new InputOption('verbose'));
        $definition->addOption(new InputOption('env'));
        $definition->addArgument(new InputArgument('env'));
    }

    public function dump()
    {
        $input = new ArrayInput(array('env' => 'prod'), $this->command->getDefinition());
        $output = new NullOutput();

        $code = $this->command->run($input, $output);

        return $code;
    }
}
