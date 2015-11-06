<?php

namespace App\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="DojangPhoneNumbers")
 */
class DojangPhoneNumber extends MappedSuperClass\PhoneNumber
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Dojang", inversedBy="phoneNumbers")
     * @JoinColumn(referencedColumnName="id")
     **/
    protected $dojang;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Set dojang
     *
     * @param Dojang $dojang
     * @return DojangPhoneNumber
     */
    public function setDojang(Dojang $dojang = null)
    {
        $this->dojang = $dojang;
        return $this;
    }

    /**
     * Get dojang
     *
     * @return Dojang
     */
    public function getDojang()
    {
        return $this->dojang;
    }
}