<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface MediaInterface extends ResourceInterface
{
    const META_FILESIZE = 'size';
    const META_WIDTH = 'width';
    const META_HEIGHT = 'height';

    public function getId();

    public function setPath($path);

    public function getPath();

    public function getName();

    public function setName($name);

    public function setUpdatedAt(\DateTime $updatedAt);

    public function getUpdatedAt();

    public function setUpdated();

    public function getMetadata();

    public function setMetadata(array $metadata);

    public function hasFile();

    public function setFile($file);

    public function getFile();

    public function getWebPath();

    public function getUploadName();

    public function setNameCallback($callback);

    public function getNameCallback();
}
