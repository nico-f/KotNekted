<?php

  namespace kot\presenceBundle\Entity;

  use FOS\UserBundle\Model\User as BaseUser;
  use Doctrine\ORM\Mapping as ORM;
  use Symfony\Component\Validator\Constraints as Assert;

  /**
   * @ORM\Entity
   * @ORM\Table(name="users")
   */
  class User extends BaseUser
  {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="mactable", mappedBy="userid")
     * @ORM\OneToMany(targetEntity="expenses", mappedBy="userid")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $nom;
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $prenom;
    /**
     * @ORM\Column(type="integer")
     */
    protected  $idLastMsgRead = 0;


    public function __construct()
    {
      parent::__construct();
      // your own logic
    }
  
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
     * Set macphone
     *
     * @param string $macphone
     * @return User
     */
    /**
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set idLastMsgRead
     *
     * @param integer $idLastMsgRead
     * @return User
     */
    public function setIdLastMsgRead($idLastMsgRead)
    {
        $this->idLastMsgRead = $idLastMsgRead;

        return $this;
    }

    /**
     * Get idLastMsgRead
     *
     * @return integer 
     */
    public function getIdLastMsgRead()
    {
        return $this->idLastMsgRead;
    }
}
