<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Storage;

interface StorageInterface
{
    /**
     * Save the styles.
     *
     * @param array $styles
     */
    public function save(array $styles);

    /**
     * Load the current styles.
     *
     * @return array $styles
     */
    public function load();
}
