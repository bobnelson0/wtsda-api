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
     * @param \Wtsda\CoreBundle\Entity\Dojang $dojang
     * @return DojangPhoneNumber
     */
    public function setDojang(\Wtsda\CoreBundle\Entity\Dojang $dojang = null)
    {
        $this->dojang = $dojang;
        return $this;
    }

    /**
     * Get dojang
     *
     * @return \Wtsda\CoreBundle\Entity\Dojang
     */
    public function getDojang()
    {
        return $this->dojang;
    }
}