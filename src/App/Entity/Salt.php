<?php
/**
 * User: Robert S. Nelson <bob.nelson@gmail.com>
 * Date: 2015-11-06
 * Time: 12:09 PM
 */
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * Password
 *
 * @Entity
 * @Table(name="PasswordSalts")
 */
class PasswordSalt extends Entity
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
     * @Column(name="string", type="string", length=40)
     */
    protected $string;

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
     * Set string
     *
     * @param string $string
     *
     * @return Password
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }
}