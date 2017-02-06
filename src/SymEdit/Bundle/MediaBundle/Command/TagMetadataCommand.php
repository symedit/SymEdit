<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Command;

use Gaufrette\Filesystem;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use SymEdit\Bundle\MediaBundle\Upload\MetadataTagger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * The files must be copied locally to determine their sizes as we don't know
 * where they could be stored with Gaufrette. It's not the best solution but
 * this command is more of a migration tool than something that would be used
 * often anyway.
 */
class TagMetadataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
             ->setName('symedit:media:tag')
             ->setDescription('Sets missing metadata on images.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (['file', 'image'] as $type) {
            $this->tagType($output, $type);
        }
    }

    protected function tagType(OutputInterface $output, $type)
    {
        $filesytem = $this->getFilesystem($type);
        $models = $this->getModels($type);
        $cacheDir = $this->getCacheDir();
        $tagger = $this->getTagger();

        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir);
        }

        // Copy temporarily
        foreach ($models as $model) {
            $tempName = tempnam($cacheDir, 'tmp_');
            file_put_contents($tempName, $filesytem->read($model->getPath()));
            $file = new File($tempName);

            // Tag
            $output->writeln(sprintf('Tagging %s: %s', $type, $model->getPath()));
            $tagger->tag($model, $file);

            // Save
            $this->flush($model);

            // Remove temp file
            @unlink($tempName);
        }
    }

    protected function getCacheDir()
    {
        return $this->getContainer()->getParameter('kernel.cache_dir').'/symedit_media';
    }

    /**
     * @return MetadataTagger
     */
    protected function getTagger()
    {
        return $this->getContainer()->get('symedit_media.metadata_tagger');
    }

    /**
     *
     * @return MediaInterface
     */
    protected function getModels($type)
    {
        return $this->getContainer()->get('symedit.repository.'.$type)->findAll();
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem($type)
    {
        return $this->getContainer()->get('symedit_media.filesystem.'.$type);
    }

    protected function flush(MediaInterface $model)
    {
        $this->getContainer()->get('doctrine')->getManager()->flush($model);
    }
}
