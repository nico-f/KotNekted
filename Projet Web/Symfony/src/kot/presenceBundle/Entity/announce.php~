<?php

namespace kot\presenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * announce
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class announce
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
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

  /**
   * @var integer
   *
   * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
   * @ORM\JoinColumn(name="id_author", referencedColumnName="id")
   */
  private $id_author;


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
     * Set message
     *
     * @param string $message
     * @return announce
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return announce
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set id_author
     *
     * @param \kot\presenceBundle\Entity\User $idAuthor
     * @return announce
     */
    public function setIdAuthor(\kot\presenceBundle\Entity\User $idAuthor = null)
    {
        $this->id_author = $idAuthor;

        return $this;
    }

    /**
     * Get id_author
     *
     * @return \kot\presenceBundle\Entity\User 
     */
    public function getIdAuthor()
    {
        return $this->id_author;
    }
}
