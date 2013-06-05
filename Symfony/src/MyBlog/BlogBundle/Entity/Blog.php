<?php

namespace MyBlog\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Description of Blog
 * @ORM\Entity(repositoryClass="MyBlog\BlogBundle\Entity\BlogRepository")
 * @ORM\Table(name="myBlog")
 * @author Rodrigo Santellan
 */
class Blog {
  
  /**
   *
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   * 
   */
  protected $id;
  
  /**
   *
   * @ORM\Column(type="string", length=100)
   */
  protected $name;
  
  /**
   *
   * @ORM\Column(type="text")
   */
  protected $body;
  
  /**
   *
   * @ORM\Column(type="string", length=100)
   */
  protected $author;
  
  /**
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="blogs")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   * @var Category
   * 
   */
  protected $category;

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
     * Set name
     *
     * @param string $name
     * @return Blog
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
     * Set body
     *
     * @param string $body
     * @return Blog
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Blog
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set category
     *
     * @param \MyBlog\BlogBundle\Entity\Category $category
     * @return Blog
     */
    public function setCategory(\MyBlog\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \MyBlog\BlogBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}