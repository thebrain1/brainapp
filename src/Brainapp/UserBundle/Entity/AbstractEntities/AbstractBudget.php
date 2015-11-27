<?php

namespace Brainapp\UserBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractBudget
 *
 * @author Chris Schneider
 */
abstract class AbstractBudget
{

    protected $id;
    protected $name;
    protected $comment;
    protected $value;
    
}
