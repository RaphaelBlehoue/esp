<?php

/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 02/11/2016
 * Time: 17:03
 */

namespace Labs\BackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Labs\BackBundle\Repository\UsersRepository")
 * @UniqueEntity(fields={"email"}, message="L'adresse email existe déjà ")
 */

class Users extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="user")
     */
    protected $gallery;

    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     * @Assert\NotNull(message="Veuillez entrez le nom")
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     * @Assert\NotNull(message="Veuillez entrez le prénom")
     */
    protected $lastname;


    /**
     * @var string
     * @ORM\Column(name="compagny", type="string", length=255, nullable=true)
     * @Assert\NotNull(message="Veuillez entrez le nom de votre entreprise")
     */
    protected $compagny;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;


    public function __construct()
    {
        parent::__construct();
        $this->created = new \DateTime('now');
        $this->gallery = new ArrayCollection();
    }

    /**
     * Sets the email.
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        return $this->setUsername($email);
    }

    /**
     * Set the canonical email.
     *
     * @param string $emailCanonical
     * @return Users
     */
    public function setEmailCanonical($emailCanonical)
    {
        parent::setEmailCanonical($emailCanonical);
        return $this->setUsernameCanonical($emailCanonical);
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Users
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Users
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add format
     *
     * @param \Labs\BackBundle\Entity\Gallery $gallery
     *
     * @return Users
     */
    public function addGallery(Gallery $gallery)
    {
        $this->gallery[] = $gallery;

        return $this;
    }

    /**
     * Remove format
     *
     * @param \Labs\BackBundle\Entity\Gallery $gallery
     */
    public function removeGallery(Gallery $gallery)
    {
        $this->gallery->removeElement($gallery);
    }

    /**
     * Get formats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set compagny
     *
     * @param string $compagny
     *
     * @return Users
     */
    public function setCompagny($compagny)
    {
        $this->compagny = $compagny;

        return $this;
    }

    /**
     * Get compagny
     *
     * @return string
     */
    public function getCompagny()
    {
        return $this->compagny;
    }

}
