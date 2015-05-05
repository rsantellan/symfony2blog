<?php

namespace Maith\PumpMyGasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="pump_it_car")
 * @ORM\Entity
 */
class Car
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
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="cars")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=false)
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity="FuelData", mappedBy="car")
     */
    private $cars;

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
     * Set model
     *
     * @param string $model
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Car
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set brand
     *
     * @param \Maith\PumpMyGasBundle\Entity\Brand $brand
     * @return Car
     */
    public function setBrand(\Maith\PumpMyGasBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Maith\PumpMyGasBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cars = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cars
     *
     * @param \Maith\PumpMyGasBundle\Entity\FuelData $cars
     * @return Car
     */
    public function addCar(\Maith\PumpMyGasBundle\Entity\FuelData $cars)
    {
        $this->cars[] = $cars;

        return $this;
    }

    /**
     * Remove cars
     *
     * @param \Maith\PumpMyGasBundle\Entity\FuelData $cars
     */
    public function removeCar(\Maith\PumpMyGasBundle\Entity\FuelData $cars)
    {
        $this->cars->removeElement($cars);
    }

    /**
     * Get cars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCars()
    {
        return $this->cars;
    }

    public function __toString()
    {
        return $this->getModel();
    }
}
