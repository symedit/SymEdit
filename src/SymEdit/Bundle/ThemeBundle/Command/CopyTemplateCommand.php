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

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CopyTemplateCommand extends AbstractThemeCommand
{
    protected function configure()
    {
        $this
            ->setName('symedit:theme:template')
            ->setDescription('Copy a template from template heirarchy that may not exist in your local theme.')
            ->addArgument('template', InputArgument::REQUIRED, 'Template to copy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('template');
        $source = $this->getTemplateSource(sprintf('@Theme/%s', $name));
        $destination = sprintf('%s/%s', $this->getTheme()->getTemplateDirectories(true), $name);

        // Remove it if it exists first
        $fs = new Filesystem();

        // You are copying the file to itself
        // @TODO: Should we just remove and ask for confirm and then find the template again?
        if ($fs->exists($destination)) {
            $output->writeln('<error>This template already exists in your theme, you would only be copying it to itself. Remove it first before copying');

            return;
        }

        // Copy contents
        $fs->dumpFile($destination, $source);

        $output->writeln(sprintf('Copied the contents of @Theme/%s to %s', $name, realpath($destination)));
    }
}
