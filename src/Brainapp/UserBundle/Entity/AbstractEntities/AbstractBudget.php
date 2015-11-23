<?php

namespace Brainapp\UserBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractBudget
{

    protected $id;
    protected $name;
    protected $comment;
    protected $value;
    
}
