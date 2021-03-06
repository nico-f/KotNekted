<?php

namespace kot\presenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * deviceType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="kot\presenceBundle\Entity\deviceTypeRepository")
 */
class deviceType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="deviceType", mappedBy="devicetypeid", cascade={"persist","remove"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=20)
     */
    private $slug;


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
     * Set slug
     *
     * @param string $slug
     * @return deviceType
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function __toString()
    {
      return $this->getSlug();
    }
}
