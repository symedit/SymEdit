<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Tests\Upload;

use Gaufrette\Filesystem;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use SymEdit\Bundle\MediaBundle\Tests\TestCase;
use SymEdit\Bundle\MediaBundle\Upload\MetadataTagger;
use SymEdit\Bundle\MediaBundle\Upload\UploadManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadManagerTest extends TestCase
{
    /**
     * @return Filesystem
     */
    private function getFilesystem()
    {
        return $this->getMockBuilder('Gaufrette\Filesystem')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * @return MetadataTagger
     */
    private function getMetadataTagger()
    {
        return $this->getMockBuilder(MetadataTagger::class)
            ->getMock()
        ;
    }

    public function getUploadManager(Filesystem $filesystem, MetadataTagger $tagger, $methods = null)
    {
        return $this->getMockBuilder(UploadManager::class)
            ->setMethods($methods)
            ->setConstructorArgs([$filesystem, $tagger])
            ->getMock()
        ;
    }

    public function getMedia()
    {
        return $this->getMockBuilder(MediaInterface::class)
            ->getMock()
        ;
    }

    public function testPreUpload()
    {
        $media = $this->getMedia();
        $metadataTagger = $this->getMetadataTagger();

        $metadataTagger
            ->expects($this->once())
            ->method('tag')
        ;

        $manager = $this->getUploadManager($this->getFilesystem(), $metadataTagger, ['removeUpload']);
        $callback = function (MediaInterface $media) {
            return 'foo';
        };

        // Return the callback
        $media
            ->expects($this->once())
            ->method('getNameCallback')
            ->will($this->returnValue($callback))
        ;

        // Expect a set name of 'foo'
        $media
            ->expects($this->once())
            ->method('setName')
            ->with($this->equalTo('foo'))
        ;

        // If it has a file, remove it
        $media
            ->expects($this->once())
            ->method('getFile')
            ->will($this->returnValue(
                $this->getFile('test')
            ))
        ;

        $manager
            ->expects($this->once())
            ->method('removeUpload')
            ->with($this->equalTo($media))
        ;

        // Upload
        $manager->preUpload($media);
    }

    protected function getFile($content)
    {
        $file = tempnam(sys_get_temp_dir(), 'symedit_media_upload');
        file_put_contents($file, $content);

        return new UploadedFile($file, 'foo.bar');
    }

    public function testNoUploadedFile()
    {
        $filesystem = $this->getFilesystem();
        $manager = $this->getUploadManager($filesystem, $this->getMetadataTagger());
        $media = $this->getMedia();

        // Don't send a file first time
        $media
            ->expects($this->once())
            ->method('getFile')
            ->will($this->returnValue(null))
        ;

        $filesystem
            ->expects($this->never())
            ->method('write')
            ->with($this->any())
        ;

        $manager->upload($media);
    }

    public function testUpload()
    {
        $filesystem = $this->getFilesystem();
        $manager = $this->getUploadManager($filesystem, $this->getMetadataTagger());
        $media = $this->getMedia();
        $file = $this->getFile('some contents');

        $media
            ->expects($this->once())
            ->method('getFile')
            ->will($this->returnValue($file))
        ;

        $media
            ->expects($this->once())
            ->method('getPath')
            ->will($this->returnValue('foo'))
        ;

        $filesystem
            ->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo('foo'),
                $this->equalTo('some contents')
            )
        ;

        $media
            ->expects($this->once())
            ->method('setFile')
            ->with($this->equalTo(null))
        ;

        $manager->upload($media);
    }

    public function testNoPathRemove()
    {
        $filesystem = $this->getFilesystem();
        $manager = $this->getUploadManager($filesystem, $this->getMetadataTagger());
        $media = $this->getMedia();

        $media
            ->expects($this->once())
            ->method('getPath')
            ->will($this->returnValue(null))
        ;

        $filesystem
            ->expects($this->never())
            ->method('has')
            ->with($this->any())
        ;

        $manager->removeUpload($media);
    }

    public function testRemoveUPload()
    {
        $filesystem = $this->getFilesystem();
        $manager = $this->getUploadManager($filesystem, $this->getMetadataTagger());
        $media = $this->getMedia();

        $media
            ->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue('foo.bar'))
        ;

        $filesystem
            ->expects($this->once())
            ->method('has')
            ->with($this->equalTo('foo.bar'))
            ->will($this->returnValue(true))
        ;

        $filesystem
            ->expects($this->once())
            ->method('delete')
            ->with($this->equalTo('foo.bar'))
        ;

        $manager->removeUpload($media);
    }
}
