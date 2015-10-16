<?php



/**
 * CountryRegion
 */
class CountryRegion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $countryId;

    /**
     * @var integer
     */
    private $regionId;


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
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return CountryRegion
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set regionId
     *
     * @param integer $regionId
     *
     * @return CountryRegion
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * Get regionId
     *
     * @return integer
     */
    public function getRegionId()
    {
        return $this->regionId;
    }
}

