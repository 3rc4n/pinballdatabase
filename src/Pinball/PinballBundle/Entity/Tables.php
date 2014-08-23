<?php

namespace Pinball\PinballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tables
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tables
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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="manufacturer", type="integer")
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    public $manufacturer;
    
    
    public function getManufacturerId() {
        return $this->manufacturer;
    }
    
    public function setManufacturerId($manufacturer) {
        $this->manufacturer = $manufacturer;
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
     * Set title
     *
     * @param string $title
     * @return Tables
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
     * Set year
     *
     * @param integer $year
     * @return Tables
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
}
