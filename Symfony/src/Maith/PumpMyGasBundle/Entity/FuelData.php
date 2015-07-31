<?php

namespace Maith\PumpMyGasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FuelData
 *
 * @ORM\Table(name="pump_it_fueltdata")
 * @ORM\Entity
 */
class FuelData
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
     * @var \DateTime
     *
     * @ORM\Column(name="fueldate", type="date")
     */
    private $fueldate;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="fuelquantity", type="float")
     */
    private $fuelquantity;

    /**
     * @var float
     *
     * @ORM\Column(name="kilometers", type="float")
     */
    private $kilometers;

    /**
     * @var float
     *
     * @ORM\Column(name="kilometerperliter", type="float")
     */
    private $kilometerperliter;

    /**
     * @var float
     *
     * @ORM\Column(name="priceperliter", type="float")
     */
    private $priceperliter;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity="Car", inversedBy="fueldatas")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id", nullable=false)
     */
    private $car;

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
     * Set fueldate
     *
     * @param \DateTime $fueldate
     * @return FuelData
     */
    public function setFueldate($fueldate)
    {
        $this->fueldate = $fueldate;

        return $this;
    }

    /**
     * Get fueldate
     *
     * @return \DateTime 
     */
    public function getFueldate()
    {
        return $this->fueldate;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return FuelData
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->calculatePricePerLiter();
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set fuelquantity
     *
     * @param float $fuelquantity
     * @return FuelData
     */
    public function setFuelquantity($fuelquantity)
    {
        $this->fuelquantity = $fuelquantity;
        $this->calculatePricePerLiter();
        $this->calculateKilometerPerLiter();
        return $this;
    }

    /**
     * Get fuelquantity
     *
     * @return float 
     */
    public function getFuelquantity()
    {
        return $this->fuelquantity;
    }

    /**
     * Set kilometers
     *
     * @param float $kilometers
     * @return FuelData
     */
    public function setKilometers($kilometers)
    {
        $this->kilometers = $kilometers;
        $this->calculateKilometerPerLiter();
        return $this;
    }

    /**
     * Get kilometers
     *
     * @return float 
     */
    public function getKilometers()
    {
        return $this->kilometers;
    }

    /**
     * Set kilometerperliter
     *
     * @param float $kilometerperliter
     * @return FuelData
     */
    public function setKilometerperliter($kilometerperliter)
    {
        $this->kilometerperliter = $kilometerperliter;

        return $this;
    }

    /**
     * Get kilometerperliter
     *
     * @return float 
     */
    public function getKilometerperliter()
    {
        return $this->kilometerperliter;
    }

    /**
     * Set priceperliter
     *
     * @param float $priceperliter
     * @return FuelData
     */
    public function setPriceperliter($priceperliter)
    {
        $this->priceperliter = $priceperliter;

        return $this;
    }

    /**
     * Get priceperliter
     *
     * @return float 
     */
    public function getPriceperliter()
    {
        return $this->priceperliter;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return FuelData
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set car
     *
     * @param \Maith\PumpMyGasBundle\Entity\Car $car
     * @return FuelData
     */
    public function setCar(\Maith\PumpMyGasBundle\Entity\Car $car)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \Maith\PumpMyGasBundle\Entity\Car 
     */
    public function getCar()
    {
        return $this->car;
    }

    private function calculatePricePerLiter()
    {
        if($this->getPrice() != null && $this->getFuelquantity() != null)
        {
            if($this->getFuelquantity() > 0)
            {
                $this->setPriceperliter($this->getPrice() / $this->getFuelquantity());
            }
        }
    }

    private function calculateKilometerPerLiter()
    {
        if($this->getKilometers() != null && $this->getFuelquantity() != null)
        {
            if($this->getFuelquantity() > 0)
            {
                $this->setKilometerperliter($this->getKilometers() / $this->getFuelquantity());
            }
        }
    }
}
