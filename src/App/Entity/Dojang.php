<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="Dojangs")
 */
class Dojang extends Entity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=30)
     */
    protected $name;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @ManyToOne(targetEntity="Region", inversedBy="dojangs")
     * @JoinColumn(referencedColumnName="id")
     **/
    protected $region;

    /**
     * @OneToMany(targetEntity="DojangAddress", mappedBy="dojang")
     */
    protected $addresses;

    /**
     * @OneToMany(targetEntity="DojangPhoneNumber", mappedBy="dojang")
     */
    protected $phoneNumbers;

    /**
     * @OneToMany(targetEntity="DojangEmailAddress", mappedBy="dojang")
     */
    protected $emailAddresses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->phoneNumbers = new ArrayCollection();
        $this->emailAddresses = new ArrayCollection();
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
     * @return Dojang
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
     * Set description
     *
     * @param string $description
     * @return Dojang
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set region
     *
     * @param \Wtsda\CoreBundle\Entity\Region $region
     * @return Dojang
     */
    public function setRegion(\Wtsda\CoreBundle\Entity\Region $region = null)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region
     *
     * @return \Wtsda\CoreBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add addresses
     *
     * @param \Wtsda\CoreBundle\Entity\DojangAddress $addresses
     * @return Dojang
     */
    public function addAddress(\Wtsda\CoreBundle\Entity\DojangAddress $addresses)
    {
        $this->addresses[] = $addresses;
        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \Wtsda\CoreBundle\Entity\DojangAddress $addresses
     * @return Dojang
     */
    public function removeAddress(\Wtsda\CoreBundle\Entity\DojangAddress $addresses)
    {
        $this->addresses->removeElement($addresses);
        return $this;
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add phoneNumbers
     *
     * @param \Wtsda\CoreBundle\Entity\DojangPhoneNumber $phoneNumbers
     * @return Dojang
     */
    public function addPhoneNumber(\Wtsda\CoreBundle\Entity\DojangPhoneNumber $phoneNumbers)
    {
        $this->phoneNumbers[] = $phoneNumbers;
        return $this;
    }

    /**
     * Remove phoneNumbers
     *
     * @param \Wtsda\CoreBundle\Entity\DojangPhoneNumber $phoneNumbers
     * @return Dojang
     */
    public function removePhoneNumber(\Wtsda\CoreBundle\Entity\DojangPhoneNumber $phoneNumbers)
    {
        $this->phoneNumbers->removeElement($phoneNumbers);
        return $this;
    }

    /**
     * Get phoneNumbers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * Add emailAddresses
     *
     * @param \Wtsda\CoreBundle\Entity\DojangEmailAddress $emailAddresses
     * @return Dojang
     */
    public function addEmailAddresses(\Wtsda\CoreBundle\Entity\DojangEmailAddress $emailAddresses)
    {
        $this->emailAddresses[] = $emailAddresses;
        return $this;
    }

    /**
     * Remove emailAddresses
     *
     * @param \Wtsda\CoreBundle\Entity\DojangEmailAddress $emailAddresses
     * @return Dojang
     */
    public function removeEmailAddresses(\Wtsda\CoreBundle\Entity\DojangEmailAddress $emailAddresses)
    {
        $this->emailAddresses->removeElement($emailAddresses);
        return $this;
    }

    /**
     * Get emailAddresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }
}
