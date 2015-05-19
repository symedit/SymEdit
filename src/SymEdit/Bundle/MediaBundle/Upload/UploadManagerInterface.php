<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Upload;

use SymEdit\Bundle\MediaBundle\Model\MediaInterface;

interface UploadManagerInterface
{
    /**
     * Prepare upload and underlying entity so it can be stored.
     *
     * @param MediaInterface $media
     */
    public function preUpload(MediaInterface $media);

    /**
     * Uploads the file.
     *
     * @param MediaInterface $media
     */
    public function upload(MediaInterface $media);

    /**
     * Remove the upload.
     *
     * @param MediaInterface $media
     */
    public function removeUpload(MediaInterface $media);
}
