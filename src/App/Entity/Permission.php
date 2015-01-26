<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="Permissions")
 */
class Permission extends Entity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=255, unique=true)
     */
    protected $resource;

    /**
     * @Column(type="string", length=255)
     */
    protected $description;

    /**
     * @ManyToMany(targetEntity="Role", mappedBy="permissions")
     */
    protected $roles;

    /**
     * @ManyToMany(targetEntity="User", mappedBy="permissions")
     */
    protected $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * Set resource
     *
     * @param string $resource
     * @return Permission
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string 
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Permission
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add roles
     *
     * @param Role $roles
     * @return Permission
     */
    public function addRole(Role $roles)
    {
        $this->roles[] = $roles;
        return $this;
    }

    /**
     * Remove roles
     *
     * @param Role $roles
     * @return Permission
     */
    public function removeRole(Role $roles)
    {
        $this->roles->removeElement($roles);
        return $this;
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add users
     *
     * @param User $users
     * @return Permission
     */
    public function addUser(User $users)
    {
        $this->users[] = $users;
        return $this;
    }

    /**
     * Remove users
     *
     * @param User $users
     * @return Permission
     */
    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
        return $this;
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
