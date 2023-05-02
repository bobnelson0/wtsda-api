<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="Ranks")
 */
class Rank extends Entity
{
    /**
     * @Column(type="string", length=30, unique=true)
     */
    protected $name;

    /**
     * @Column(type="integer")
     */
    protected $ord;

    /**
     * @ManyToOne(targetEntity="RankGroup", inversedBy="ranks")
     * @JoinColumn(referencedColumnName="id")
     */
    protected $rankGroup;

    /**
     * @OneToMany(targetEntity="Profile", mappedBy="rank")
     */
    protected $profiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->profiles = new ArrayCollection();
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
     * @return Rank
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
     * @return Rank
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
     * Set rankGroup
     *
     * @param RankGroup $rankGroup
     * @return Rank
     */
    public function setRankGroup(RankGroup $rankGroup = null)
    {
        $this->rankGroup = $rankGroup;
        return $this;
    }

    /**
     * Get rankGroup
     *
     * @return RankGroup
     */
    public function getRankGroup()
    {
        return $this->rankGroup;
    }

    /**
     * Add profiles
     *
     * @param Profile $profiles
     * @return Rank
     */
    public function addProfile(Profile $profiles)
    {
        $this->profiles[] = $profiles;
        return $this;
    }

    /**
     * Remove profiles
     *
     * @param Profile $profiles
     * @return Rank
     */
    public function removeProfile(Profile $profiles)
    {
        $this->profiles->removeElement($profiles);
        return $this;
    }

    /**
     * Get profiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}
