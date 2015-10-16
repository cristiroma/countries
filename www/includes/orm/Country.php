<?php

/**
 * Country
 */
class Country
{
    /**
     * @var integer
     */
    private $id = '0';

    /**
     * @var integer
     */
    private $enabled = '1';

    /**
     * @var string
     */
    private $code3l;

    /**
     * @var string
     */
    private $code2l;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nameOfficial;

    /**
     * @var string
     */
    private $flag32;

    /**
     * @var string
     */
    private $flag128;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var integer
     */
    private $zoom;


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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Country
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set code3l
     *
     * @param string $code3l
     *
     * @return Country
     */
    public function setCode3l($code3l)
    {
        $this->code3l = $code3l;

        return $this;
    }

    /**
     * Get code3l
     *
     * @return string
     */
    public function getCode3l()
    {
        return $this->code3l;
    }

    /**
     * Set code2l
     *
     * @param string $code2l
     *
     * @return Country
     */
    public function setCode2l($code2l)
    {
        $this->code2l = $code2l;

        return $this;
    }

    /**
     * Get code2l
     *
     * @return string
     */
    public function getCode2l()
    {
        return $this->code2l;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Country
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
     * Set nameOfficial
     *
     * @param string $nameOfficial
     *
     * @return Country
     */
    public function setNameOfficial($nameOfficial)
    {
        $this->nameOfficial = $nameOfficial;

        return $this;
    }

    /**
     * Get nameOfficial
     *
     * @return string
     */
    public function getNameOfficial()
    {
        return $this->nameOfficial;
    }

    /**
     * Set flag32
     *
     * @param string $flag32
     *
     * @return Country
     */
    public function setFlag32($flag32)
    {
        $this->flag32 = $flag32;

        return $this;
    }

    /**
     * Get flag32
     *
     * @return string
     */
    public function getFlag32()
    {
        return $this->flag32;
    }

    /**
     * Set flag128
     *
     * @param string $flag128
     *
     * @return Country
     */
    public function setFlag128($flag128)
    {
        $this->flag128 = $flag128;

        return $this;
    }

    /**
     * Get flag128
     *
     * @return string
     */
    public function getFlag128()
    {
        return $this->flag128;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Country
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
     *
     * @return Country
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

    /**
     * Set zoom
     *
     * @param integer $zoom
     *
     * @return Country
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Get zoom
     *
     * @return integer
     */
    public function getZoom()
    {
        return $this->zoom;
    }
}

