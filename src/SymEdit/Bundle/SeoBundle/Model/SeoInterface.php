<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Model;

interface SeoInterface extends SeoAbleInterface
{
    /**
     * Add a meta tag.
     *
     * @param string $type
     * @param string $key
     * @param string $content
     */
    public function addMeta($type, $key, $content);

    /**
     * Shortcut to addMeta('property', ..., ...).
     *
     * @param string $property
     * @param string $content
     */
    public function addMetaProperty($property, $content);

    /**
     * Shortcut to addMeta('name', ..., ...).
     *
     * @param string $name
     * @param string $content
     */
    public function addMetaName($name, $content);

    /**
     * Check if meta exists.
     *
     * @return bool
     */
    public function hasMeta($type, $key = null);

    /**
     * Get meta tags. Either returns an array or a specific entry.
     *
     * @param string $type
     * @param string $key
     */
    public function getMetas($type = null, $key = null);

    /**
     * Set all meta tags.
     *
     * @param array $metas
     */
    public function setMetas(array $metas = []);

    /**
     * Get links for page, grouped by rel attribute.
     *
     * @param string $rel
     */
    public function getLinks($rel = null);

    /**
     * Set links. Should be an array of arrays with rel being the key.
     *
     * @param array $links
     */
    public function setLinks(array $links = []);

    /**
     * Gets current SEO Subject.
     *
     * @return mixed
     */
    public function getSubject();

    /**
     * Set SEO Subject.
     *
     * @param mixed $subject
     * @param bool  $replace
     */
    public function setSubject($subject, $replace = true);

    /**
     * Get Page Title.
     */
    public function getTitle();

    /**
     * Set Page Title.
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * Get Page Description.
     */
    public function getDescription();

    /**
     * Set Page Description.
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Get Keywords.
     */
    public function getKeywords();

    /**
     * Set Keywords.
     *
     * @param string $keywords
     */
    public function setKeywords($keywords);

    /**
     * Add HTML Attribute.
     *
     * @param string $attr
     * @param string $value
     */
    public function addHtmlAttr($attr, $value);

    /**
     * Get HTML Attribute(s).
     *
     * @param string $attr
     */
    public function getHtmlAttrs($attr = null);

    /**
     * Get index for robots.
     */
    public function getIndex();

    /**
     * Set index for robots.
     *
     * @param bool $index
     */
    public function setIndex($index);

    /**
     * Set noIndex.
     */
    public function noIndex();

    /**
     * Set Index.
     */
    public function index();

    /**
     * Get follow for robots.
     */
    public function getFollow();

    /**
     * Set follow for robots.
     *
     * @param bool $follow
     */
    public function setFollow($follow);

    /**
     * Set noFollow.
     */
    public function noFollow();

    /**
     * Set Follow.
     */
    public function follow();

    /**
     * Resets all SEO.
     */
    public function reset();
}
