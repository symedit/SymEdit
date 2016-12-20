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

abstract class Media implements MediaInterface
{
    protected $id;
    protected $callback;
    protected $file;
    protected $path;
    protected $name;
    protected $updatedAt;
    protected $metadata = [];
    protected $prefix = '';

    public function __toString()
    {
        return $this->getPath();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return BeverageImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        if ($this->hasFile()) {
            $this->setPath($this->getUploadName());
        }
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return BeverageImage
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setUpdated()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function hasFile()
    {
        return ($this->file !== null || $this->path !== null);
    }

    public function setFile($file)
    {
        $this->file = $file;
        $this->setUpdated();
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getWebPath()
    {
        if ($this->path === null) {
            return;
        }

        return sprintf('/%s/%s', trim($this->getPrefix(), '/'), $this->getPath());
    }

    public function getUploadName()
    {
        return $this->name.'.'.$this->file->guessExtension();
    }

    public function setNameCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception('Callback is not callable.');
        }

        $this->callback = $callback;
    }

    public function getNameCallback()
    {
        return $this->callback;
    }
}
