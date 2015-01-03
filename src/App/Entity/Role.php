<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="Roles")
 */
class Role extends Entity
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
     * @Column(type="string", length=255)
     */
    protected $description;

    /**
     * @Column(type="integer")
     */
    protected $ord;

    /**
     * @OneToMany(targetEntity="User", mappedBy="role")
     */
    protected $users;

    /**
     * @ManyToMany(targetEntity="Permission", inversedBy="roles")
     * @JoinTable(name="RolePermissions")
     */
    protected $permissions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
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
     * @return Role
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
     * @return Role
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
     * Set ord
     *
     * @param int $ord
     * @throws \InvalidArgumentException if $ord is not an integer
     * @return Role
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
     * Add users
     *
     * @param User $user
     * @return User
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
        return $this;
    }

    /**
     * Remove users
     *
     * @param User $user
     * @return User
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
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

    /**
     * Add permissions
     *
     * @param \Wtsda\CoreBundle\Entity\Permission $permissions
     * @return Role
     */
    public function addPermission(Permission $permissions)
    {
        $this->permissions[] = $permissions;
        return $this;
    }

    /**
     * Remove permissions
     *
     * @param \Wtsda\CoreBundle\Entity\Permission $permissions
     * @return Role
     */
    public function removePermission(Permission $permissions)
    {
        $this->permissions->removeElement($permissions);
        return $this;
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
