<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="HyungTypes")
 */
class HyungType extends Entity
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
     * @OneToMany(targetEntity="Hyung", mappedBy="type")
     */
    protected $hyungs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hyungs = new ArrayCollection();
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
     * @return HyungType
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
     * Add hyungs
     *
     * @param Hyung $hyungs
     * @return HyungType
     */
    public function addHyung(Hyung $hyungs)
    {
        $this->hyungs[] = $hyungs;
        return $this;
    }

    /**
     * Remove hyungs
     *
     * @param Hyung $hyungs
     * @return HyungType
     */
    public function removeHyung(Hyung $hyungs)
    {
        $this->hyungs->removeElement($hyungs);
        return $this;
    }

    /**
     * Get hyungs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHyungs()
    {
        return $this->hyungs;
    }
}
