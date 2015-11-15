<?php

namespace Brainapp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usergroup
 *
 * @ORM\Table(name="tbl_group", options={"comment":"Tabelle Benutzergruppen"})
 * @ORM\Entity(repositoryClass="Brainapp\UserBundle\Entity\UsergroupRepository")
 */
class Usergroup
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
     * @ORM\Column(name="name", type="string", length=255, options={"comment":"Gruppenbezeichnung"})
     */
    private $name;


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
     * @return Usergroup
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
}

