<?php

namespace Brainapp\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="core_user")
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserRepository")
 */
class User
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
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="givenname", type="string", length=255)
     */
    private $givenname;


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
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set givenname
     *
     * @param string $givenname
     *
     * @return User
     */
    public function setGivenname($givenname)
    {
        $this->givenname = $givenname;

        return $this;
    }

    /**
     * Get givenname
     *
     * @return string
     */
    public function getGivenname()
    {
        return $this->givenname;
    }
}

