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

class Seo implements SeoInterface
{
    protected $subject;

    protected $title;
    protected $description;
    protected $keywords;

    protected $index;
    protected $follow;

    protected $metas;
    protected $links;
    protected $htmlAttrs;

    public static $allowedProperties = [
        'title', 'description', 'keywords',
        'subject', 'index', 'follow',
        'metas', 'links', 'htmlAttrs',
    ];

    public function __construct($subject = null)
    {
        $this->reset();
        $this->subject = $subject;
    }

    public function reset()
    {
        $this->title = '';
        $this->description = '';
        $this->keywords = '';

        $this->index = true;
        $this->follow = true;

        $this->metas = [];
        $this->links = [];
        $this->htmlAttrs = [];
    }

    public function addMeta($type, $key, $content)
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = [];
        }

        $this->metas[$type][$key] = $content;

        return $this;
    }

    public function addMetaProperty($property, $content)
    {
        return $this->addMeta('property', $property, $content);
    }

    public function addMetaName($name, $content)
    {
        return $this->addMeta('name', $name, $content);
    }

    public function hasMeta($type, $key = null)
    {
        if (!isset($this->metas[$type])) {
            return false;
        } elseif ($key === null) {
            return true;
        }

        return isset($this->metas[$type][$key]);
    }

    public function getMetas($type = null, $key = null)
    {
        if ($type === null) {
            return $this->metas;
        }

        $metas = $this->metas[$type];

        return $key === null ? $metas : $metas[$key];
    }

    public function setMetas(array $metas = [])
    {
        $this->metas = $metas;
    }

    public function addLink($rel, $href)
    {
        if (!isset($this->links[$rel])) {
            $this->links[$rel] = [];
        }

        $this->links[$rel][] = $href;

        return $this;
    }

    public function getLinks($rel = null)
    {
        return $rel === null ? $this->links : $this->links[$rel];
    }

    public function setLinks(array $links = [])
    {
        $this->links = $links;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function noIndex()
    {
        return $this->setIndex(false);
    }

    public function index()
    {
        return $this->setIndex(true);
    }

    public function getFollow()
    {
        return $this->follow;
    }

    public function setFollow($follow)
    {
        $this->follow = $follow;

        return $this;
    }

    public function noFollow()
    {
        return $this->setFollow(false);
    }

    public function follow()
    {
        return $this->setFollow(true);
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject, $replace = true)
    {
        $this->subject = $subject;

        if ($replace && $subject instanceof SeoAbleInterface) {
            $this->replace($subject);
        }

        return $this;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function addHtmlAttr($attr, $value)
    {
        $this->htmlAttrs[$attr] = $value;
    }

    public function getHtmlAttrs($attr = null)
    {
        return $attr === null ? $this->htmlAttrs : $this->htmlAttrs[$attr];
    }

    public function replace($seo)
    {
        if ($seo instanceof SeoAbleInterface) {
            $seo = $seo->getSeo();
        }

        /*
         * Reset properties
         */
        $this->reset();

        foreach (self::$allowedProperties as $prop) {
            if (!isset($seo[$prop])) {
                continue;
            }

            $method = sprintf('set%s', ucfirst($prop));
            $this->$method($seo[$prop]);
        }

        return $this;
    }

    public function merge($seo, $replaceExisting = false)
    {
        if ($seo instanceof SeoAbleInterface) {
            $seo = $seo->getSeo();
        }

        foreach (self::$allowedProperties as $prop) {
            if (!isset($seo[$prop])) {
                continue;
            }

            $getter = sprintf('get%s', ucfirst($prop));
            $setter = sprintf('set%s', ucfirst($prop));
            $newValue = $seo[$prop];
            $currentValue = $this->$getter();

            /*
             * If not empty, merge this in if it's not blank, always merge
             * arrays.
             */
            if (is_array($currentValue)) {
                $newValue = array_replace_recursive($currentValue, $newValue);
                $this->$setter($newValue);

                continue;
            }

            /*
             * - If new value is empty don't change
             * - If we're replacing, then set new one no matter what
             * - If not replacing, check to see if current value is empty first
             */
            if ((!empty($newValue) || is_bool($newValue)) && ($replaceExisting || empty($currentValue))) {
                $this->$setter($newValue);
            }
        }
    }

    public function getSeo()
    {
        $outputArray = [];

        foreach (self::$allowedProperties as $prop) {
            $method = sprintf('get%s', ucfirst($prop));
            $outputArray[$prop] = $this->$method();
        }

        return $outputArray;
    }
}
