<?php

namespace App\Entity\MappedSuperClass;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @MappedSuperclass
 */
class PhoneNumber extends Entity
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
     * @Column(name="number", type="string", length=255, nullable=false)
     */
    protected $number;

    /**
     * Set type
     *
     * @param string $type
     *
     * @return PhoneNumbers
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
     * Set number
     *
     * @param string $number
     *
     * @return PhoneNumbers
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}