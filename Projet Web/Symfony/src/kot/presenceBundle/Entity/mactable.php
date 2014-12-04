<?php

namespace kot\presenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * mactable
 *
 * @ORM\Entity(repositoryClass="kot\presenceBundle\Entity\mactableRepository")
 * @ORM\Table(name ="mactable",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="macad_unique", columns={"macad"})},
 *      indexes={@ORM\Index(name="mac_user_idx", columns={"userid"}), @ORM\Index(name="mac_devicetype_idx", columns={"devicetypeid"})})
 */
class mactable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="userid", referencedColumnName="id")
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="macad", type="string", length=17, unique=true)
     */
    private $macad;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="deviceType", inversedBy="id")
     * @ORM\JoinColumn(name="devicetypeid", referencedColumnName="id")
     */
    private $devicetypeid;


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
     * Set macad
     *
     * @param string $macad
     * @return mactable
     */
    public function setMacad($macad)
    {
        $this->macad = $macad;

        return $this;
    }

    /**
     * Get macad
     *
     * @return string 
     */
    public function getMacad()
    {
        return $this->macad;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return mactable
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return mactable
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set devicetypeid
     *
     * @param integer $devicetypeid
     * @return mactable
     */
    public function setDevicetypeid($devicetypeid)
    {
        $this->devicetypeid = $devicetypeid;

        return $this;
    }

    /**
     * Get devicetypeid
     *
     * @return integer 
     */
    public function getDevicetypeid()
    {
        return $this->devicetypeid;
    }

}
