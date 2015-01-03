<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="RankGroups")
 */
class RankGroup extends Entity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=30, unique=true)
     */
    protected $name;

    /**
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
        $this->ranks = new ArrayCollection();
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
     * @throws \InvalidArgumentException if $ord is not an integer
     * @return RankGroup
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
