<?php

namespace App\Entity\MappedSuperClass;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @MappedSuperclass
 */
class Address extends Entity
{
    /**
     * @Column(type="string", length=30)
     * e.g. mailing, physical, home, work
     */
    protected $type;

    /**
     * @Column(type="string", length=255)
     * e.g. 123 Main St, City, State 54321
     */
    protected $formatted;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    protected $streetNumber;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    protected $streetName;

    /**
     * @Column(type="string", length=255, nullable=true)
     * e.g. APT 123, Suite 404
     */
    protected $domicile;

    /**
     * @Column(type="string", length=255)
     * Indicates a named route (such as "US 101", nullable=true)
     */
    protected $route;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a major intersection, usually of two major roads
     */
    protected $intersection;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a political entity. Usually, this type indicates a polygon of some civil administration
     */
    protected $political;

    /**
     * @Column(type="string", length=255)
     */
    protected $country;

    /**
     * @Column(type="string", length=255)
     * Indicates a first-order civil entity below the country level.
     * Within the United States, these administrative levels are states.
     */
    protected $adminLevel1;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a second-order civil entity below the country level.
     * Within the United States, these administrative levels are counties.
     */
    protected $adminLevel2;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a third-order civil entity below the country level.
     * This type indicates a minor civil division.
     */
    protected $adminLevel3;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a commonly-used alternative name for the entity.
     */
    protected $colloquialArea;

    /**
     * @Column(type="string", length=255)
     * Indicates an incorporated city or town political entity.
     */
    protected $locality;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a first-order civil entity below a locality.
     */
    protected $subLocality;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Each sublocality level is a civil entity.
     */
    protected $subLocality1;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Each sublocality level is a civil entity.
     */
    protected $subLocality2;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Each sublocality level is a civil entity.
     */
    protected $subLocality3;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Each sublocality level is a civil entity.
     */
    protected $subLocality4;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Each sublocality level is a civil entity.
     */
    protected $subLocality5;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a named neighborhood
     */
    protected $neighborhood;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a named location, usually a building or collection of buildings with a common name.
     */
    protected $premise;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a first-order entity below a named location,
     * usually a singular building within a collection of buildings with a common name
     */
    protected $subPremise;

    /**
     * @Column(type="string", length=255)
     */
    protected $postalCode;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a prominent natural feature.
     */
    protected $naturalFeature;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates an airport.
     */
    protected $airport;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a named park.
     */
    protected $park;

    /**
     * @Column(type="string", length=255, nullable=true)
     * Indicates a named point of interest.
     * Typically, these "POI"s are prominent local entities that don't easily fit in another category such as
     * "Empire State Building" or "Statue of Liberty."
     */
    protected $pointOfInterest;

    /**
     * @Column(type="decimal", precision=18, scale=12, nullable=true)
     * Geographic coordinate that specifies the north-south position of a point on the Earth's surface.
     * Ranges from -90 to 90
     */
    protected $latitude;

    /**
     * @Column(type="decimal", precision=18, scale=12, nullable=true)
     * Geographic coordinate that specifies the east-west position of a point on the Earth's surface.
     * Ranges from -180 to 180
     */
    protected $longitude;

    /**
     * Set type
     *
     * @param string $type
     * @return Address
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
     * Set formatted
     *
     * @param string $formatted
     * @return Address
     */
    public function setFormatted($formatted)
    {
        $this->formatted = $formatted;
        return $this;
    }

    /**
     * Get formatted
     *
     * @return string
     */
    public function getFormatted()
    {
        return $this->formatted;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     * @return Address
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set streetName
     *
     * @param string $streetName
     * @return Address
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * Get streetName
     *
     * @return string
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * Set domicile
     *
     * @param string $domicile
     * @return Address
     */
    public function setDomicile($domicile)
    {
        $this->domicile = $domicile;
        return $this;
    }

    /**
     * Get domicile
     *
     * @return string
     */
    public function getDomicile()
    {
        return $this->domicile;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Address
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Get domicile
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set intersection
     *
     * @param string $intersection
     * @return Address
     */
    public function setIntersection($intersection)
    {
        $this->intersection = $intersection;
        return $this;
    }

    /**
     * Get intersection
     *
     * @return string
     */
    public function getIntersection()
    {
        return $this->intersection;
    }

    /**
     * Set political
     *
     * @param string $political
     * @return Address
     */
    public function setPolitical($political)
    {
        $this->political = $political;
        return $this;
    }

    /**
     * Get political
     *
     * @return string
     */
    public function getPolitical()
    {
        return $this->political;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set adminLevel1
     *
     * @param string $adminLevel1
     * @return Address
     */
    public function setAdminLevel1($adminLevel1)
    {
        $this->adminLevel1 = $adminLevel1;
        return $this;
    }

    /**
     * Get adminLevel1
     *
     * @return string
     */
    public function getAdminLevel1()
    {
        return $this->adminLevel1;
    }

    /**
     * Set adminLevel2
     *
     * @param string $adminLevel2
     * @return Address
     */
    public function setAdminLevel2($adminLevel2)
    {
        $this->adminLevel2 = $adminLevel2;
        return $this;
    }

    /**
     * Get adminLevel2
     *
     * @return string
     */
    public function getAdminLevel2()
    {
        return $this->adminLevel2;
    }

    /**
     * Set adminLevel3
     *
     * @param string $adminLevel3
     * @return Address
     */
    public function setAdminLevel3($adminLevel3)
    {
        $this->adminLevel3 = $adminLevel3;
        return $this;
    }

    /**
     * Get adminLevel3
     *
     * @return string
     */
    public function getAdminLevel3()
    {
        return $this->adminLevel3;
    }

    /**
     * Set colloquialArea
     *
     * @param string $colloquialArea
     * @return Address
     */
    public function setColloquialArea($colloquialArea)
    {
        $this->colloquialArea = $colloquialArea;
        return $this;
    }

    /**
     * Get colloquialArea
     *
     * @return string
     */
    public function getColloquialArea()
    {
        return $this->colloquialArea;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return Address
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
        return $this;
    }

    /**
     * Get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set subLocality
     *
     * @param string $subLocality
     * @return Address
     */
    public function setSubLocality($subLocality)
    {
        $this->subLocality = $subLocality;
        return $this;
    }

    /**
     * Get subLocality
     *
     * @return string
     */
    public function getSubLocality()
    {
        return $this->subLocality;
    }

    /**
     * Set subLocality1
     *
     * @param string $subLocality1
     * @return Address
     */
    public function setSubLocality1($subLocality1)
    {
        $this->subLocality1 = $subLocality1;
        return $this;
    }

    /**
     * Get subLocality1
     *
     * @return string
     */
    public function getSubLocality1()
    {
        return $this->subLocality1;
    }

    /**
     * Set subLocality2
     *
     * @param string $subLocality2
     * @return Address
     */
    public function setSubLocality2($subLocality2)
    {
        $this->subLocality2 = $subLocality2;
        return $this;
    }

    /**
     * Get subLocality2
     *
     * @return string
     */
    public function getSubLocality2()
    {
        return $this->subLocality2;
    }

    /**
     * Set subLocality3
     *
     * @param string $subLocality3
     * @return Address
     */
    public function setSubLocality3($subLocality3)
    {
        $this->subLocality3 = $subLocality3;
        return $this;
    }

    /**
     * Get subLocality3
     *
     * @return string
     */
    public function getSubLocality3()
    {
        return $this->subLocality3;
    }

    /**
     * Set subLocality4
     *
     * @param string $subLocality4
     * @return Address
     */
    public function setSubLocality4($subLocality4)
    {
        $this->subLocality4 = $subLocality4;
        return $this;
    }

    /**
     * Get subLocality4
     *
     * @return string
     */
    public function getSubLocality4()
    {
        return $this->subLocality4;
    }

    /**
     * Set subLocality5
     *
     * @param string $subLocality5
     * @return Address
     */
    public function setSubLocality5($subLocality5)
    {
        $this->subLocality5 = $subLocality5;
        return $this;
    }

    /**
     * Get subLocality5
     *
     * @return string
     */
    public function getSubLocality5()
    {
        return $this->subLocality5;
    }

    /**
     * Set neighborhood
     *
     * @param string $neighborhood
     * @return Address
     */
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }

    /**
     * Get neighborhood
     *
     * @return string
     */
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * Set premise
     *
     * @param string $premise
     * @return Address
     */
    public function setPremise($premise)
    {
        $this->premise = $premise;
        return $this;
    }

    /**
     * Get premise
     *
     * @return string
     */
    public function getPremise()
    {
        return $this->premise;
    }

    /**
     * Set subPremise
     *
     * @param string $subPremise
     * @return Address
     */
    public function setSubPremise($subPremise)
    {
        $this->subPremise = $subPremise;
        return $this;
    }

    /**
     * Get subPremise
     *
     * @return string
     */
    public function getSubPremise()
    {
        return $this->subPremise;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Address
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set naturalFeature
     *
     * @param string $naturalFeature
     * @return Address
     */
    public function setNaturalFeature($naturalFeature)
    {
        $this->naturalFeature = $naturalFeature;
        return $this;
    }

    /**
     * Get naturalFeature
     *
     * @return string
     */
    public function getNaturalFeature()
    {
        return $this->naturalFeature;
    }

    /**
     * Set airport
     *
     * @param string $airport
     * @return Address
     */
    public function setAirport($airport)
    {
        $this->airport = $airport;
        return $this;
    }

    /**
     * Get airport
     *
     * @return string
     */
    public function getAirport()
    {
        return $this->airport;
    }

    /**
     * Set park
     *
     * @param string $park
     * @return Address
     */
    public function setPark($park)
    {
        $this->park = $park;
        return $this;
    }

    /**
     * Get park
     *
     * @return string
     */
    public function getPark()
    {
        return $this->park;
    }

    /**
     * Set pointOfInterest
     *
     * @param string $pointOfInterest
     * @return Address
     */
    public function setPointOfInterest($pointOfInterest)
    {
        $this->pointOfInterest = $pointOfInterest;
        return $this;
    }

    /**
     * Get pointOfInterest
     *
     * @return string
     */
    public function getPointOfInterest()
    {
        return $this->pointOfInterest;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
