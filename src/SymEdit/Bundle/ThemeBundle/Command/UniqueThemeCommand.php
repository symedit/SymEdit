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

use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class UniqueThemeCommand extends AbstractThemeCommand
{
    protected $fs;

    protected function configure()
    {
        $this
            ->setName('symedit:theme:unique')
            ->setDescription('Check the templates of a theme with its parent themes to see if any templates are the same.')
            ->addArgument('theme', InputArgument::OPTIONAL, 'Theme name to check')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('theme');
        $theme = $this->getTheme($name);

        if (!$theme->getParentTheme()) {
            $output->writeln('<error>The theme does not have a parent and cannot be checked for uniqueness.</error>');

            return;
        }

        $finder = new Finder();
        $finder->files()->in($theme->getTemplateDirectories(true))->name('*.html.twig');

        foreach ($finder as $file) {
            $this->checkUniqueness($theme->getParentTheme(), $file, $input, $output);
        }
    }

    protected function checkUniqueness(ThemeInterface $theme, SplFileInfo $themeFile, InputInterface $input, OutputInterface $output)
    {
        $parentDirectory = $theme->getTemplateDirectories(true);
        $parentFile = $parentDirectory.'/'.$themeFile->getRelativePathname();

        if ($this->compareFiles($themeFile, $parentFile)) {
            $question = sprintf(
                '<question>"%s" is the same as the template in the <info>%s</info> theme, would you like to remove it from your current theme?</question>',
                $themeFile->getRelativePathname(),
                $theme->getName()
            );

            if ($this->getHelper('dialog')->askConfirmation($output, $question, false)) {
                $this->getFilesystem()->remove($themeFile);
                $output->writeln('Removed '.$themeFile);
                $output->writeln('');
            }
        }

        if ($theme->getParentTheme()) {
            $this->checkUniqueness($theme->getParentTheme(), $themeFile, $input, $output);
        }
    }

    protected function compareFiles($themeFile, $parentFile)
    {
        return file_exists($parentFile) && $this->getFileHash($themeFile) === $this->getFileHash($parentFile);
    }

    protected function getFileHash($filename)
    {
        return md5(file_get_contents($filename));
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        if ($this->fs === null) {
            $this->fs = new Filesystem();
        }

        return $this->fs;
    }
}
