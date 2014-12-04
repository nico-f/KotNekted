<?php

namespace kot\presenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * expenses
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="kot\presenceBundle\Entity\expensesRepository")
 */
class expenses
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
   * @ORM\Column(type="decimal",precision=6, scale=2)
   */
    private  $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="usrid", referencedColumnName="id")
     */
    private $usrid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set description
     *
     * @param string $description
     * @return expenses
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set amount
     *
     * @param string $amount
     * @return expenses
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set usrid
     *
     * @param \kot\presenceBundle\Entity\User $usrid
     * @return expenses
     */
    public function setUsrid(\kot\presenceBundle\Entity\User $usrid = null)
    {
        $this->usrid = $usrid;

        return $this;
    }

    /**
     * Get usrid
     *
     * @return \kot\presenceBundle\Entity\User 
     */
    public function getUsrid()
    {
        return $this->usrid;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return expenses
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
