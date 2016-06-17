<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Tests\Namer;

use SymEdit\Bundle\MediaBundle\Namer\SlugNamer;
use SymEdit\Bundle\MediaBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SlugNamerTest extends TestCase
{
    protected $namer;
    protected $file;

    public function setUp()
    {
        $this->namer = new SlugNamer();
        $this->file = tempnam(sys_get_temp_dir(), 'media_test');
    }

    public function tearDown()
    {
        unlink($this->file);
    }

    /**
     * @dataProvider slugProvider
     */
    public function testSlugNamer($name, $expected)
    {
        $file = new UploadedFile($this->file, $name);
        $slug = $this->namer->getName($file);

        $this->assertEquals($expected, $slug);
    }

    public function slugProvider()
    {
        return [
            ['basic', 'basic'],
            ['some space', 'some-space'],
            ['mañana', 'manana'],
            ['uPPer CaSE', 'upper-case'],
        ];
    }
}
