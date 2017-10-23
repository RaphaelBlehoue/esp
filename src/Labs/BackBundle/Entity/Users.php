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
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
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

    public function __construct()
    {
        parent::__construct();
        $this->gallery = new ArrayCollection();
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
}