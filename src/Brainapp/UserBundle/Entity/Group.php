<?php

namespace Brainapp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * Group Entity
 *
 * @ORM\Table(name="tbl_group", options={"comment":"Tabelle Benutzergruppen"})
 * @ORM\Entity(repositoryClass="Brainapp\UserBundle\Entity\GroupRepository")
 */
class Group extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct($name, $roles = array())
    {
    	parent::__construct($name, $roles);
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
}
