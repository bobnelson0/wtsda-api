<?php

namespace App\Entity;

use App\Entity;
use App\Util\Validation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="RankGroups")
 */
class RankGroup extends Entity
{
    /**
     * @Column(type="string", length=30, unique=true)
     */
    protected $name;

    /**
     * Used for sorting purposes
     * Lowest value starts at 1
     *
     * @Column(type="integer")
     */
    protected $ord;

    /**
     * @OneToMany(targetEntity="Rank", mappedBy="rankGroup")
     */
    protected $ranks;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->ranks = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return RankGroup
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
     * Set ord
     *
     * @param int $ord
     * @throws \InvalidArgumentException if $ord is not an integer greater than 0
     * @return RankGroup
     */
    public function setOrd($ord)
    {
        if(!Validation::isValidOrd($ord)) {
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
     * Add ranks
     *
     * @param Rank $ranks
     * @return RankGroup
     */
    public function addRank(Rank $ranks)
    {
        $this->ranks[] = $ranks;
        return $this;
    }

    /**
     * Remove ranks
     *
     * @param Rank $ranks
     * @return RankGroup
     */
    public function removeRank(Rank $ranks)
    {
        $this->ranks->removeElement($ranks);
        return $this;
    }

    /**
     * Get ranks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRanks()
    {
        return $this->ranks;
    }
}
