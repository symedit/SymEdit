<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use SymEdit\Bundle\CoreBundle\Iterator\RecursivePageIterator;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class Page implements PageInterface, ResourceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $homepage;

    /**
     * @var bool
     */
    protected $root;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $tagline;

    /**
     * @var string
     */
    protected $summary;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $displayOptions = [];

    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $seo;

    /**
     * @var int
     */
    protected $pageOrder;

    /**
     * @var bool
     */
    protected $display;

    /**
     * @var ImageInterface
     */
    protected $image;

    /**
     * @var bool
     */
    protected $crawl;

    /**
     * @var bool
     */
    protected $pageController;

    /**
     * @var string
     */
    protected $pageControllerPath;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $updatedBy;

    /**
     * @var PageInterface Parent page or null for root
     */
    protected $parent;

    /**
     * @var ArrayCollection Children of this page
     */
    protected $children;

    /**
     * @var int
     */
    protected $level;

    /**
     * @var string Template Name
     */
    protected $template;

    protected $active;

    public function __toString()
    {
        return $this->getRoot() ? 'Root' : sprintf('%s %s', str_repeat('-', $this->getLevel()), $this->getTitle());
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->setHomepage(false);
        $this->setRoot(false);
        $this->setDisplay(true);
        $this->setCrawl(true);
        $this->setPageController(false);
        $this->setUpdatedAt(new \DateTime());
        $this->setActive(false);
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set homepage.
     *
     * @param bool $homepage
     *
     * @return Page
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage.
     *
     * @return bool
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set root.
     *
     * @param bool $root
     *
     * @return Page
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root.
     *
     * @return bool
     */
    public function getRoot()
    {
        return $this->root;
    }

    public function getRootNode()
    {
        $node = $this;

        while (!$node->getRoot()) {
            $node = $node->getParent();
        }

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set tagline.
     *
     * @param string $tagline
     *
     * @return Page
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * Get tagline.
     *
     * @return string
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * Set summary.
     *
     * @param string $summary
     *
     * @return Page
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary.
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritDoc}
     */
    public function setDisplayOptions(array $displayOptions)
    {
        $this->displayOptions = $displayOptions;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayOptions()
    {
        return $this->displayOptions;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set seo.
     *
     * @param array $seo
     *
     * @return Page
     */
    public function setSeo(array $seo = [])
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo.
     *
     * @return array
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Set pageOrder.
     *
     * @param int $pageOrder
     *
     * @return Page
     */
    public function setPageOrder($pageOrder)
    {
        $this->pageOrder = $pageOrder;

        return $this;
    }

    /**
     * Get pageOrder.
     *
     * @return int
     */
    public function getPageOrder()
    {
        return $this->pageOrder;
    }

    /**
     * Set display.
     *
     * @param bool $display
     *
     * @return Page
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display.
     *
     * @return bool
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setImage(ImageInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Set crawl.
     *
     * @param bool $crawl
     *
     * @return Page
     */
    public function setCrawl($crawl)
    {
        $this->crawl = $crawl;

        return $this;
    }

    /**
     * Get crawl.
     *
     * @return bool
     */
    public function getCrawl()
    {
        return $this->crawl;
    }

    /**
     * Set pageController.
     *
     * @param bool $pageController
     *
     * @return Page
     */
    public function setPageController($pageController)
    {
        $this->pageController = $pageController;

        return $this;
    }

    /**
     * Get pageController.
     *
     * @return bool
     */
    public function getPageController()
    {
        return $this->pageController;
    }

    /**
     * Set pageControllerPath.
     *
     * @param string $pageControllerPath
     *
     * @return Page
     */
    public function setPageControllerPath($pageControllerPath)
    {
        $this->pageControllerPath = $pageControllerPath;

        return $this;
    }

    /**
     * Get pageControllerPath.
     *
     * @return string
     */
    public function getPageControllerPath()
    {
        return $this->pageControllerPath;
    }

    /**
     * Gets time created.
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get created by.
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updated at.
     *
     * @param \DateTime $time
     *
     * @return Page
     */
    public function setUpdatedAt($time)
    {
        $this->updatedAt = $time;

        return $this;
    }

    /**
     * Get updated at.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get Updated By.
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

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
        $path = $this->path;

        if ($this->getPageController()) {
            $path = rtrim($path, '/').'/';
        }

        return $path;
    }

    public function getRoute()
    {
        return sprintf('page/%d', $this->getId());
    }

    /**
     * Set parent.
     *
     * @param PageInterface $parent
     *
     * @return PageInterface
     */
    public function setParent(PageInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return PageInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children.
     *
     * @param PageInterface $children
     *
     * @return Page
     */
    public function addChildren(PageInterface $children)
    {
        $children->setParent($this);
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children.
     *
     * @param PageInterface $children
     */
    public function removeChildren(PageInterface $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children.
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set template.
     *
     * @param string $template
     *
     * @return Page
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    public function setActive($active, $traverse = false)
    {
        $this->active = $active;

        if ($traverse && $this->getParent()) {
            $this->getParent()->setActive($active, true);
        }
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getVisibleChildren()
    {
        return $this->getChildren()->filter(function ($en) {
            return $en->getDisplay();
        });
    }

    public function getSiblings()
    {
        if (!$this->getParent()) {
            return [];
        }

        return $this->getParent()->getChildren()->filter(function ($element) {
            return $element !== $this;
        });
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getIterator()
    {
        return new RecursivePageIterator($this);
    }

    public function isNameValid(ExecutionContextInterface $context)
    {
        if ($this->getHomepage() && $this->getName() != '') {
            $context->addViolationAt('name', 'The "name" field for the Homepage must be blank');

            return;
        } elseif (!$this->getHomepage() && $this->getName() == '') {
            $context->addViolationAt('name', 'The "name" field must not be blank');
        }

        foreach ($this->getSiblings() as $child) {
            if ($child->getName() === $this->getName()) {
                $context->addViolationAt('name', 'This name is already used for another sibling page');

                break;
            }
        }
    }

    public function isParentValid(ExecutionContextInterface $context)
    {
        $page = $this;

        while ($parent = $page->getParent()) {
            if ($this->getId() === $parent->getId()) {
                $context->addViolationAt('parent', 'Choosing this parent page creates a loop. Please choose another.');

                return;
            }

            $page = $parent;
        }
    }
}
