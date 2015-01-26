<?php

namespace App\Entity\MappedSuperClass;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @MappedSuperclass
 */
class EmailAddress extends Entity
{
    /**
     * @var string
     *
     * @Column(name="type", type="string", length=30, nullable=false)
     */
    protected $type;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * Set type
     *
     * @param string $type
     *
     * @return EmailAddress
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return EmailAddress
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}