<?php

namespace Loopita\MetalizadoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 * 
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @ORM\Table(name="metalurgica_project")
 * @author Rodrigo Santellan
 */
class Project {
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
   * @ORM\Column(type="string", length=100, nullable=true)
   */
  protected $cliente;
  
  /**
   *
   * @ORM\Column(type="text", nullable=true)
   */
  protected $tipo_de_trabajo;
  
  /**
   *
   * @ORM\Column(type="text", nullable=true)
   */
  protected $description;
  
  
  /**
   * @Gedmo\SortablePosition
   * @ORM\Column(type="integer")
   */
  protected $orden;
  

  /**
   *
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="projects")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   * @Assert\NotBlank()
   * 
   */
  protected $category;

  /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
    */
  protected $slug;
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
     * @return Project
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
     * Set cliente
     *
     * @param string $cliente
     * @return Project
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return string 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipo_de_trabajo
     *
     * @param string $tipoDeTrabajo
     * @return Project
     */
    public function setTipoDeTrabajo($tipoDeTrabajo)
    {
        $this->tipo_de_trabajo = $tipoDeTrabajo;
    
        return $this;
    }

    /**
     * Get tipo_de_trabajo
     *
     * @return string 
     */
    public function getTipoDeTrabajo()
    {
        return $this->tipo_de_trabajo;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return Project
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set category
     *
     * @param \Loopita\MetalizadoraBundle\Entity\Category $category
     * @return Project
     */
    public function setCategory(\Loopita\MetalizadoraBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Loopita\MetalizadoraBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Project
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    public function getFullClassName()
    {
      return get_class($this);
    }
}