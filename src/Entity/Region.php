<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity
 */
class Region
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_unep", type="boolean", nullable=false)
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
