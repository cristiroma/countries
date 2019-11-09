<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CountryRegion
 *
 * @ORM\Table(name="country_region", uniqueConstraints={@ORM\UniqueConstraint(name="country_id", columns={"country_id", "region_id"})}, indexes={@ORM\Index(name="fk_country_region__region_idx", columns={"region_id"}), @ORM\Index(name="IDX_4F1A1A05F92F3E70", columns={"country_id"})})
 * @ORM\Entity
 */
class CountryRegion
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
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="countryRegions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * })
     */
    private $region;



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
     * Set region
     *
     * @param \Region $region
     *
     * @return CountryRegion
     */
    public function setRegion(\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Region
     */
    public function getRegion()
    {
        return $this->region;
    }
}
