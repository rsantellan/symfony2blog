<?php

namespace Maith\Common\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of mFile
 * 
 * @ORM\Table(name="maith_file")
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @author Rodrigo Santellan
 */
class mFile {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
      * @Gedmo\SortablePosition
      * @ORM\Column(type="integer")
      */
     protected $orden;
     
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    
      /**
      *
      * @ORM\ManyToOne(targetEntity="mAlbum", inversedBy="files")
      * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
      * 
      */
     protected $album;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return mFile
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
     * Set name
     *
     * @param string $name
     * @return mFile
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
     * Set path
     *
     * @param string $path
     * @return mFile
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
        return $this->path;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return mFile
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set album
     *
     * @param \Maith\Common\AdminBundle\Entity\mAlbum $album
     * @return mFile
     */
    public function setAlbum(\Maith\Common\AdminBundle\Entity\mAlbum $album = null)
    {
        $this->album = $album;
    
        return $this;
    }

    /**
     * Get album
     *
     * @return \Maith\Common\AdminBundle\Entity\mAlbum 
     */
    public function getAlbum()
    {
        return $this->album;
    }
}