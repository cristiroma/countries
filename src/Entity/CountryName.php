<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CountryName
 *
 * @ORM\Table(name="country_name", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQUE_country_language", columns={"country_id", "language"})}, indexes={@ORM\Index(name="fk_country_name__country_idx", columns={"country_id"})})
 * @ORM\Entity
 */
class CountryName implements JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Country
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="countryNames")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=5, nullable=false)
     */
    private $language = '';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_official", type="string", length=255, nullable=true)
     */
    private $nameOfficial;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;



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
     * Set country
     *
     * @param \Country $country
     *
     * @return CountryRegion
     */
    public function setCountry(\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Country
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * Set language
     *
     * @param string $language
     *
     * @return CountryName
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CountryName
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
     * @return CountryName
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
     * Set source
     *
     * @param string $source
     *
     * @return CountryName
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
    
    public function jsonSerialize()
    {
        return array(
            'language'=>$this->language,
            'name'=>$this->name,
            'nameOfficial'=>$this->nameOfficial
        );
    }
}
