<?php

namespace MyBlog\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="myBlogCategory")
 * @ORM\Entity(repositoryClass="MyBlog\BlogBundle\Entity\CategoryRepository")
 * @author Rodrigo Santellan
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * var Blog
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="category")
     */
    private $blogs;
    
    
    public function setId($id)
    {
      $this->id = $id;
      return $this;
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
     * Set name
     *
     * @param string $name
     * @return Category
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
    
    public function __construct() {
      $this->blogs = new ArrayCollection();
    }

    /**
     * Add blogs
     *
     * @param \MyBlog\BlogBundle\Entity\Blog $blogs
     * @return Category
     */
    public function addBlog(\MyBlog\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;
    
        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \MyBlog\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\MyBlog\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
    
    public function __toString() {
      return $this->getName();
    }
}