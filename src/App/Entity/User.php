<?php

namespace App\Entity;

use App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="Users")
 */
class User extends Entity
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(name="username", type="string", length=255, unique=true)
     */
    protected $username;

    /**
     * @var integer
     *
     * @Column(name="created", type="bigint")
     */
    protected $created;

    /**
     * @var integer
     *
     * @Column(name="lastLogin", type="bigint")
     */
    protected $lastLogin;

    /**
     * @var string
     *
     * @Column(name="salt", type="string", length=40, nullable=true)
     */
    protected $salt;

    /**
     * @var boolean
     *
     * @Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @OneToOne(targetEntity="Password")
     * @JoinColumn(name="password_id", referencedColumnName="id")
     **/
    protected $password;

    /**
     * @ManyToOne(targetEntity="Role", inversedBy="users")
     * @JoinColumn(referencedColumnName="id")
     **/
    protected $role;

    /**
     * @ManyToMany(targetEntity="Permission", inversedBy="users")
     * @JoinTable(name="UserPermissions")
     */
    protected $permissions;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set created
     *
     * @param integer $created
     * @throws \InvalidArgumentException if $created is not an integer
     * @return User
     */
    public function setCreated($created)
    {
        if(!is_integer($created)) {
            throw new \InvalidArgumentException;
        }
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return integer
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set lastLogin
     *
     * @param integer $lastLogin
     * @throws \InvalidArgumentException if $lastLogin is not an integer
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        if(!is_integer($lastLogin)) {
            throw new \InvalidArgumentException;
        }
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return integer
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set salt
     * Generates a salt based on the username and sha1
     * @throws \InvalidArgumentException
     * @return User
     */
    public function setSalt()
    {
        if(empty($this->username)) {
            throw new \InvalidArgumentException;
        }
        $salt = sha1($this->username);
        $this->salt = $salt;
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @throws \InvalidArgumentException if $active is boolean
     * @return User
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
     * Set password
     *
     * @param Password $password
     * @return User
     */
    public function setPassword(Password $password = null)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param Role $role
     * @return User
     */
    public function setRole(Role $role = null)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add permissions
     *
     * @param Permission $permissions
     * @return User
     */
    public function addPermission(Permission $permissions)
    {
        $this->permissions[] = $permissions;
        return $this;
    }

    /**
     * Remove permissions
     *
     * @param Permission $permissions
     * @return User
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

