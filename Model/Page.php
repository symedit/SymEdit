<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Doctrine\Common\Collections\ArrayCollection; 
use Symfony\Component\Validator\ExecutionContext;

abstract class Page implements PageInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var boolean $homepage
     */
    protected $homepage;

    /**
     * @var boolean $root
     */
    protected $root;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $tagline
     */
    protected $tagline;

    /**
     * @var string $summary
     */
    protected $summary;

    /**
     * @var string $path
     */
    protected $path;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $content
     */
    protected $content;

    /**
     * @var array $seo
     */
    protected $seo;

    /**
     * @var integer $pageOrder
     */
    protected $pageOrder;

    /**
     * @var boolean $display
     */
    protected $display;

    /**
     * @var boolean $crawl
     */
    protected $crawl;

    /**
     * @var boolean $pageController
     */
    protected $pageController;

    /**
     * @var string $pageControllerPath
     */
    protected $pageControllerPath;

    /**
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @var Isometriks\Bundle\SymEditBundle\Entity\Page Parent page or null for root
     */
    protected $parent;

    /**
     * @var ArrayCollection Children of this page
     */
    protected $children;
    
    /**
     * @var ArrayCollection Chunks associated to this page
     */
    protected $chunks; 

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
     * Constructor
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
        $this->setPageOrder(1000);
        $this->setActive(false);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set homepage
     *
     * @param boolean $homepage
     * @return Page
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return boolean 
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Set root
     *
     * @param boolean $root
     * @return Page
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return boolean 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set tagline
     *
     * @param string $tagline
     * @return Page
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * Get tagline
     *
     * @return string 
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Page
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set seo
     *
     * @param array $seo
     * @return Page
     */
    public function setSeo(array $seo = array())
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return array 
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Set pageOrder
     *
     * @param integer $pageOrder
     * @return Page
     */
    public function setPageOrder($pageOrder)
    {
        $this->pageOrder = $pageOrder;

        return $this;
    }

    /**
     * Get pageOrder
     *
     * @return integer 
     */
    public function getPageOrder()
    {
        return $this->pageOrder;
    }

    /**
     * Set display
     *
     * @param boolean $display
     * @return Page
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return boolean 
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set crawl
     *
     * @param boolean $crawl
     * @return Page
     */
    public function setCrawl($crawl)
    {
        $this->crawl = $crawl;

        return $this;
    }

    /**
     * Get crawl
     *
     * @return boolean 
     */
    public function getCrawl()
    {
        return $this->crawl;
    }

    /**
     * Set pageController
     *
     * @param boolean $pageController
     * @return Page
     */
    public function setPageController($pageController)
    {
        $this->pageController = $pageController;

        return $this;
    }

    /**
     * Get pageController
     *
     * @return boolean 
     */
    public function getPageController()
    {
        return $this->pageController;
    }

    /**
     * Set pageControllerPath
     *
     * @param string $pageControllerPath
     * @return Page
     */
    public function setPageControllerPath($pageControllerPath)
    {
        $this->pageControllerPath = $pageControllerPath;

        return $this;
    }

    /**
     * Get pageControllerPath
     *
     * @return string 
     */
    public function getPageControllerPath()
    {
        return $this->pageControllerPath;
    }

    /**
     * Set updated at
     *
     * @param \DateTime $time
     * @return Page
     */
    public function setUpdatedAt($time)
    {
        $this->updatedAt = $time;

        return $this;
    }

    /**
     * Get updated at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Page
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        if($this->getRoot()){
            return ''; 
        }
        
        $path = $this->path; 
        
        if($this->getPageController()){
            $path = rtrim($path, '/') . '/'; 
        }
        
        return $path; 
    }
    
    public function getRoute()
    {
        if($this->getHomepage()){
            return 'homepage'; 
        } else {
            return 'page' . str_replace(array('-','/'), '_', rtrim($this->getPath(), '/')); 
        }
    }

    /**
     * Set parent
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Page $parent
     * @return Page
     */
    public function setParent(PageInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Isometriks\Bundle\SymEditBundle\Entity\Page 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Page $children
     * @return Page
     */
    public function addChildren(PageInterface $children)
    {
        $children->setParent($this); 
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Page $children
     */
    public function removeChildren(PageInterface $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Page
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
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
        return $this->getChildren()->filter(function($en) {
            return $en->getDisplay();
        });
    }
    
    public function getBreadcrumbs()
    {
        if($this->getRoot() || $this->getHomepage() || $this->getParent() === null){
            return array(); 
        } else {
            return array_merge($this->getParent()->getBreadcrumbs(), array($this)); 
        }
    }
   
    
    public function getLevel()
    {
        if($this->getRoot()){
            return 0; 
        } else {
            return $this->getParent()->getLevel() + 1; 
        }
    }

    /**
     * PrePersist
     */
    public function fixPath()
    {
        if ($this->getRoot()) {
            $this->setPath('');
        } else {
            $parent_path = $this->getParent() ? $this->getParent()->getPath() : ''; 
            $path = rtrim($parent_path, '/') . '/' . $this->getName(); 
            
            $this->setPath($path); 
        }
    }

    public function setUpdated()
    {
        // Set Updated at to now
        $this->setUpdatedAt(new \DateTime());

        // Set the path to be parent path/page name
        $this->fixPath();

        // In case this page's path has changed, let's fix the children too
        foreach ($this->getChildren() as $child) {
            $child->setUpdated();
        }
    }

    public function isNameValid(ExecutionContext $context)
    {
        if ($this->getHomepage()) {
            if ($this->getName() != '') {
                $context->addViolationAtSubPath('name', 'The "name" field for the Homepage must be blank');
            }
        } else {
            if ($this->getName() == '') {
                $context->addViolationAtSubPath('name', 'The "name" field must not be blank');
            }
        }
    }

    /**
     * Add chunks
     *
     * @param \Isometriks\Bundle\SymEditBundle\Model\ChunkInterface $chunks
     * @return Page
     */
    public function addChunk(ChunkInterface $chunks)
    {
        $chunks->setPage($this); 
        $this->chunks[] = $chunks;
    
        return $this;
    }

    /**
     * Remove chunks
     *
     * @param \Isometriks\Bundle\SymEditBundle\Model\ChunkInterface $chunks
     */
    public function removeChunk(ChunkInterface $chunks)
    {
        $this->chunks->removeElement($chunks);
    }

    /**
     * Get chunks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChunks()
    {
        return $this->chunks;
    }
    
    /**
     * Get a chunk by its name
     * 
     * @param string $name
     * @return \Isometriks\Bundle\SymEditBundle\Model\ChunkInterface $chunk
     * @throws \Exception When chunk cannot be found by name
     */
    public function getChunk($name)
    {
        foreach($this->getChunks() as $chunk){
            if($chunk->getName() === $name){
                return $chunk; 
            }
        }
        
        return null;
    }    
}