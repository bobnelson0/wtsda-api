<?php

namespace App\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="ProfileEmailAddresses")
 */
class ProfileEmailAddress extends MappedSuperClass\EmailAddress
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Profile", inversedBy="emailAddresses")
     * @JoinColumn(referencedColumnName="id")
     **/
    protected $profile;

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
     * Set profile
     *
     * @param Profile $profile
     * @return ProfileEmailAddress
     */
    public function setProfile(Profile $profile = null)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}