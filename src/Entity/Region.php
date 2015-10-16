<?php



/**
 * Region
 */
class Region
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $isUnep = '0';


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
     *
     * @return Region
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
     * Set isUnep
     *
     * @param boolean $isUnep
     *
     * @return Region
     */
    public function setIsUnep($isUnep)
    {
        $this->isUnep = $isUnep;

        return $this;
    }

    /**
     * Get isUnep
     *
     * @return boolean
     */
    public function getIsUnep()
    {
        return $this->isUnep;
    }
}

