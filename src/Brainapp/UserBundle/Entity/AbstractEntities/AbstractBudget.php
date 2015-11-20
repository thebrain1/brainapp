<?php

namespace Brainapp\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diese abstrakte Klasse repräsentiert ein Budget (entweder ein GruppenBudget oder ein persönliches UserBudget)
 * @ORMEntity
 * @ORMTable(name="budget")
 * @ORMInheritanceType("SINGLE_TABLE")
 * @ORMDiscriminatorColumn(name="type", type="string")
 * @ORMDiscriminatorMap( {"groupBudget" = "GroupBudget", "userBudget" = "UserBudget"} )
 */
abstract class AbstractBudget
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	
	/**
     * @ORMId
     * @ORMColumn(type="integer")
     * @ORMGeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORMColumn(type="string")
     */
    protected $name;
    
    /**
     * @ORMColumn(type="string")
     */
    protected $comment;
    
    /**
     * @ORMColumn(type="float")
     */
    protected $value;
    
}
