<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="Regions")
 */
class Region extends Entity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(name="number", type="integer", unique=true)
     */
    protected $number;

    /**
     * @Column(type="string", length=255)
     */
    protected $description;

    /**
     * @Column(type="integer")
     */
    protected $ord;

    /**
     * @OneToMany(targetEntity="Dojang", mappedBy="region")
     */
    protected $dojangs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dojangs = new ArrayCollection();
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
     * Set number
     *
     * @param string $number
     * @throws \InvalidArgumentException if $number is not an integer
     * @return Region
     */
    public function setNumber($number)
    {
        if(!is_int($number)) {
            throw new \InvalidArgumentException;
        }
        $this->number = $number;
        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Region
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
     * Set ord
     *
     * @param int $ord
     * @throws \InvalidArgumentException if $ord is not an integer
     * @return Region
     */
    public function setOrd($ord)
    {
        if(!is_int($ord)) {
            throw new \InvalidArgumentException;
        }
        $this->ord = $ord;
        return $this;
    }

    /**
     * Get ord
     *
     * @return integer
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Add dojangs
     *
     * @param Dojang $dojangs
     * @return Region
     */
    public function addDojang(Dojang $dojangs)
    {
        $this->dojangs[] = $dojangs;
        return $this;
    }

    /**
     * Remove dojangs
     *
     * @param Dojang $dojangs
     * @return Region
     */
    public function removeDojang(Dojang $dojangs)
    {
        $this->dojangs->removeElement($dojangs);
        return $this;
    }

    /**
     * Get dojangs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDojangs()
    {
        return $this->dojangs;
    }
}