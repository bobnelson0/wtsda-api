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
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=30)
     */
    protected $firstName;

    /**
     * @Column(type="string", length=30, nullable=true)
     */
    protected $middleName;

    /**
     * @Column(type="string", length=30)
     */
    protected $lastName;

    /**
     * @Column(type="string", length=6, nullable=true)
     */
    protected $associationNumber;

    /**
     * @Column(type="date")
     */
    protected $dateOfBirth;

    /**
     * @Column(type="string", length=1)
     */
    protected $gender;

    /**
     * @Column(name="active", type="boolean")
     */
    protected $active;

    /** Relationship definitions */

    /**
     * @ManyToOne(targetEntity="Region", inversedBy="profiles")
     * @JoinColumn(referencedColumnName="id")
     **/
    protected $region;

    /**
     * @ManyToOne(targetEntity="Rank", inversedBy="profiles")
     * @JoinColumn(referencedColumnName="id")
     **/
    protected $rank;

    /**
     * TODO : fix me
     */
    protected $rankGroup = 'FIX ME';

    /**
     * @OneToMany(targetEntity="ProfileAddress", mappedBy="profile")
     */
    protected $addresses;

    /**
     * @OneToMany(targetEntity="ProfilePhoneNumber", mappedBy="profile")
     */
    protected $phoneNumbers;

    /**
     * @OneToMany(targetEntity="ProfileEmailAddress", mappedBy="profile")
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
     * Set region
     *
     * @param Region $region
     * @return Dojang
     */
    public function setRegion(Region $region = null)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set rank
     *
     * @param Rank $rank
     * @return Dojang
     */
    public function setRank(Rank $rank = null)
    {
        $this->rank = $rank;
        return $this;
    }

    /**
     * Get rank
     *
     * @return Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add addresses
     *
     * @param ProfileAddress $addresses
     * @return Profile
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
     * region
     * rank
     * rankGroup
     * dojang
     * judge_cert
     * inst_cert
     * addresses
     * phoneNumbers
     * emailAddresses
     *
     *
     */
}