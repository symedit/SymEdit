<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('symedit:install')
            ->setDescription('Install SymEdit and get it running.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'No dialogs, forces all.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $force = (boolean) $input->getOption('force');
        $helper = $this->getHelper('question');

        // Doctrine create database
        $createQuestion = new ConfirmationQuestion('<question>Create Database?</question>', false);
        if ($force || $helper->ask($input, $output, $createQuestion)) {
            $output->writeln('Creating database...');

            $command = $this->getApplication()->find('doctrine:database:create');
            $input = new ArrayInput(['command' => 'doctrine:database:create', '-n' => $force]);
            $returnCode = $command->run($input, $output);
        }

        // Doctrine schema update
        $schemaQuestion = new ConfirmationQuestion('<question>Load Schema?</question>', false);
        if ($force || $helper->ask($input, $output, $schemaQuestion)) {
            $output->writeln('Loading Schema...');

            $command = $this->getApplication()->find('doctrine:schema:update');
            $input = new ArrayInput([
                'command' => 'doctrine:schema:update',
                '--force' => true,
                '-n' => $force,
            ]);
            $returnCode = $command->run($input, $output);
        }

        // Doctrine Fixtures
        $fixtureQuestion = new ConfirmationQuestion('<question>Load Fixtures?</question>', false);
        if ($force || $helper->ask($input, $output, $fixtureQuestion)) {
            $output->writeln('Loading Fixtures...');

            $command = $this->getApplication()->find('doctrine:fixtures:load');
            $input = new ArrayInput(['doctrine:fixtures:load']);
            $input->setInteractive(!$force);
            $returnCode = $command->run($input, $output);
        }

        $output->writeln('Finished.');
    }
}
