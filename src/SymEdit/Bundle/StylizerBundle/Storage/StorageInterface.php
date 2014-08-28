<?php

namespace SymEdit\Bundle\StylizerBundle\Storage;

interface StorageInterface
{
    /**
     * Save the styles
     *
     * @param array $styles
     */
    public function save(array $styles);

    /**
     * Load the current styles
     *
     * @return array $styles
     */
    public function load();
}
