<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="Profiles")
 */
class Profile extends Entity
{
    /**
     * @var integer
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(type="string", length=30)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @Column(type="string", length=30, nullable=true)
     */
    protected $middleName;

    /**
     * @var string
     *
     * @Column(type="string", length=30)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @Column(type="string", length=6, nullable=true)
     */
    protected $associationNumber;

    /**
     * @var \Date
     *
     * @Column(type="date")
     */
    protected $dateOfBirth;

    /**
     * @var \string
     *
     * @Column(type="string", length=1)
     */
    protected $gender;

    /**
     * @var boolean
     *
     * @Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @OneToMany(targetEntity="ProfileAddress", mappedBy="profile")
     */
    protected $addresses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @throws \InvalidArgumentException if $active is boolean
     * @return Profile
     */
    public function setActive($active)
    {
        if(!is_bool($active)) {
            throw new \InvalidArgumentException;
        }
        $this->active = $active;
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add addresses
     *
     * @param ProfileAddress $addresses
     * @return address
     */
    public function addAddress(ProfileAddress $addresses)
    {
        $this->addresses[] = $addresses;
        return $this;
    }

    /**
     * Remove addresses
     *
     * @param ProfileAddress $addresses
     * @return Profile
     */
    public function removeAddress(ProfileAddress $addresses)
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
     * @param ProfilePhoneNumber $phoneNumbers
     * @return Profile
     */
    public function addPhoneNumber(ProfilePhoneNumber $phoneNumbers)
    {
        $this->phoneNumbers[] = $phoneNumbers;
        return $this;
    }

    /**
     * Remove phoneNumbers
     *
     * @param ProfilePhoneNumber $phoneNumbers
     * @return Profile
     */
    public function removePhoneNumber(ProfilePhoneNumber $phoneNumbers)
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
     * @param ProfileEmailAddress $emailAddresses
     * @return Profile
     */
    public function addEmailAddresses(ProfileEmailAddress $emailAddresses)
    {
        $this->emailAddresses[] = $emailAddresses;
        return $this;
    }

    /**
     * Remove emailAddresses
     *
     * @param ProfileEmailAddress $emailAddresses
     * @return Profile
     */
    public function removeEmailAddresses(ProfileEmailAddress $emailAddresses)
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



    /**
     * class only:
     * id
     * firstname
     * middlename
     * lastname
     * assocNum
     * dob
     * gender
     * active
     *
     *
     * linked:
     * rank
     * dojang
     * judge_cert
     * inst_cert
     *
     *
     */
}