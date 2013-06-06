<?php

namespace Loopita\MetalizadoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="metalizadora_category")
 * @ORM\Entity(repositoryClass="Loopita\MetalizadoraBundle\Entity\CategoryRepository")
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
     * @ORM\OneToMany(targetEntity="Project", mappedBy="category")
     */
    private $projects;

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
      $this->projects = new ArrayCollection();
    }

    public function __toString() {
      return $this->getName();
    }

    /**
     * Add projects
     *
     * @param \Loopita\MetalizadoraBundle\Entity\Project $projects
     * @return Category
     */
    public function addProject(\Loopita\MetalizadoraBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Loopita\MetalizadoraBundle\Entity\Project $projects
     */
    public function removeProject(\Loopita\MetalizadoraBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }
}