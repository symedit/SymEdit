<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContext;
use Isometriks\Bundle\SymEditBundle\Model\UpdatableInterface; 

/**
 * 
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="Isometriks\Bundle\SymEditBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Page implements UpdatableInterface 
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean $homepage
     *
     * @ORM\Column(name="homepage", type="boolean")
     */
    protected $homepage;

    /**
     * @var boolean $root
     *
     * @ORM\Column(name="root", type="boolean")
     */
    protected $root;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string $tagline
     *
     * @ORM\Column(name="tagline", type="string", length=255, nullable=true)
     */
    protected $tagline;

    /**
     * @var string $summary
     *
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    protected $summary;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    protected $path;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    protected $content;

    /**
     * @var array $seo
     *
     * @ORM\Column(name="seo", type="json_array", nullable=true)
     */
    protected $seo;

    /**
     * @var integer $pageOrder
     *
     * @ORM\Column(name="pageOrder", type="integer")
     */
    protected $pageOrder;

    /**
     * @var boolean $display
     *
     * @ORM\Column(name="display", type="boolean")
     */
    protected $display;

    /**
     * @var boolean $crawl
     *
     * @ORM\Column(name="crawl", type="boolean")
     */
    protected $crawl;

    /**
     * @var boolean $pageController
     *
     * @ORM\Column(name="pageController", type="boolean")
     */
    protected $pageController;

    /**
     * @var string $pageControllerPath
     *
     * @ORM\Column(name="pageControllerPath", type="string", length=255, nullable=true)
     */
    protected $pageControllerPath;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent", cascade={"persist","remove"})
     * @ORM\OrderBy({"pageOrder"="ASC"})
     */
    protected $children;
    
    /**
     * @ORM\OneToMany(targetEntity="Chunk", mappedBy="page", cascade={"persist", "remove"})
     */
    protected $chunks; 

    /**
     * @ORM\Column(name="template", length=255, nullable=true)
     */
    protected $template;

    public function __toString()
    {
        return $this->getRoot() ? 'Root' : sprintf('%s %s', str_repeat('-', $this->getLevel()), $this->getTitle()); 
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setSeo(array(
            'index' => 'index', 
            'follow' => 'follow', 
        ));
        $this->setHomepage(false);
        $this->setRoot(false);
        $this->setDisplay(true);
        $this->setCrawl(true);
        $this->setPageController(false);
        $this->setUpdatedAt(new \DateTime());
        $this->setPageOrder(1000);
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
            return 'page' . str_replace(array('-','/'), '_', $this->getPath()); 
        }
    }

    /**
     * Set parent
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Page $parent
     * @return Page
     */
    public function setParent(\Isometriks\Bundle\SymEditBundle\Entity\Page $parent = null)
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
    public function addChildren(\Isometriks\Bundle\SymEditBundle\Entity\Page $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Page $children
     */
    public function removeChildren(\Isometriks\Bundle\SymEditBundle\Entity\Page $children)
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

    protected $active = false;

    public function setActive($active, $traverse)
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
     * @ORM\PrePersist
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
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Chunk $chunks
     * @return Page
     */
    public function addChunk(\Isometriks\Bundle\SymEditBundle\Entity\Chunk $chunks)
    {
        $chunks->setPage($this); 
        $this->chunks[] = $chunks;
    
        return $this;
    }

    /**
     * Remove chunks
     *
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Chunk $chunks
     */
    public function removeChunk(\Isometriks\Bundle\SymEditBundle\Entity\Chunk $chunks)
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
     * @return \Isometriks\Bundle\SymEditBundle\Entity\Chunk $chunk
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