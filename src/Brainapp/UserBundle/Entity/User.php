<?php

namespace Brainapp\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="tbl_user", options={"comment":"Tabelle Benutzer"})
 * @ORM\Entity(repositoryClass="Brainapp\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected  $id;

    /**
     * @ORM\ManyToMany(targetEntity="Brainapp\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="tbl_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    public function __construct()
    {
    	parent::__construct();
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

