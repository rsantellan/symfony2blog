<?php

namespace Loopita\MetalizadoraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 * 
 * @ORM\Entity(repositoryClass="Loopita\MetalizadoraBundle\Entity\ProjectRepository")
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
   * @ORM\Column(type="string", length=100)
   */
  protected $cliente;
  
  /**
   *
   * @ORM\Column(type="text")
   */
  protected $tipo_de_trabajo;
  
  /**
   *
   * @ORM\Column(type="text")
   */
  protected $description;
  
  
  /**
   *
   * @ORM\Column(type="integer")
   */
  protected $orden;
  

  /**
   *
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="projects")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
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
}