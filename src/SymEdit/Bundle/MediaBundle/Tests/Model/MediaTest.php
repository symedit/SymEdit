<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Tests\Model;

use SymEdit\Bundle\MediaBundle\Model\Media;
use SymEdit\Bundle\MediaBundle\Tests\TestCase;

class MediaTest extends TestCase
{
    protected $file;

    public function setUp()
    {
        $this->file = tempnam(sys_get_temp_dir(), 'symedit_media');
    }

    /**
     * @return Media
     */
    protected function createMedia()
    {
        return $this->getMockForAbstractClass('SymEdit\Bundle\MediaBundle\Model\Media');
    }

    public function testId()
    {
        $media = $this->createMedia();
        $this->assertNull($media->getId());
    }

    public function testPath()
    {
        $media = $this->createMedia();
        $this->assertNull($media->getPath());

        $media->setPath('/foo');
        $this->assertEquals('/foo', $media->getPath());
    }

    public function testName()
    {
        $media = $this->createMedia();
        $this->assertNull($media->getName());

        $media->setName('bar');
        $this->assertEquals('bar', $media->getName());
    }

    public function testUpdated()
    {
        $media = $this->createMedia();
        $this->assertNull($media->getUpdatedAt());

        $now = new \DateTime();
        $media->setUpdatedAt($now);
        $this->assertEquals($now, $media->getUpdatedAt());

        $media->setUpdated();
        $now->modify('+1 second');
        $this->assertLessThan($now, $media->getUpdatedAt());
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile Uploaded File
     */
    protected function createFile()
    {
        return $this->getMockBuilder('Symfony\Component\HttpFoundation\File\UploadedFile', ['guessExtension'])
            ->enableOriginalConstructor()
            ->setConstructorArgs([
               $this->file,
               'media_test',
            ])
            ->getMock();
    }

    public function testHasFile()
    {
        $media = $this->createMedia();
        $this->assertFalse($media->hasFile());
        $media->setPath('/foo');
        $this->assertTrue($media->hasFile());

        $media = $this->createMedia();
        $media->setFile($this->createFile());
        $this->assertTrue($media->hasFile());
    }

    public function testSetPath()
    {
        $media = $this->createMedia();
        $file = $this->createFile();
        $file->expects($this->any())
             ->method('guessExtension')
             ->will($this->returnValue('jpg'));

        $media->setFile($file);
        $media->setName('foo');

        $this->assertEquals('foo.jpg', $media->getPath());
    }

    public function prefixTest()
    {
        $media = $this->createMedia();
        $this->assertEquals('', $media->getPrefix());

        $media->setPrefix('foo');
        $this->assertEquals('foo', $media->getPrefix());
    }

    public function testWebPath()
    {
        $media = $this->createMedia();
        $this->assertNull($media->getWebPath());

        $media->setPrefix('foo');
        $media->setPath('bar');
        $this->assertEquals('/foo/bar', $media->getWebPath());

        // Try with slash
        $media->setPrefix('/foo/');
        $this->assertEquals('/foo/bar', $media->getWebPath());
    }

    public function testUploadName()
    {
        $media = $this->createMedia();
        $file = $this->createFile();
        $file->expects($this->once())
             ->method('guessExtension')
             ->will($this->returnValue('jpg'));

        $media->setName('foo');
        $media->setFile($file);

        $this->assertEquals('foo.jpg', $media->getUploadName());
    }

    /**
     * @expectedException \Exception
     */
    public function testCallbackException()
    {
        $media = $this->createMedia();
        $media->setNameCallback(null);
    }

    public function testCallback()
    {
        $media = $this->createMedia();
        $this->assertNull($media->getNameCallback());

        $callback = function () {
        };
        $media->setNameCallback($callback);
        $this->assertEquals($callback, $media->getNameCallback());
    }
}
