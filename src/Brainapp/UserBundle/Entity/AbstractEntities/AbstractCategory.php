<?php

namespace Brainapp\UserBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Diese Klasse repräsentiert eine Kategorie, entweder die einer Gruppe oder eines (persönliche) des Users.
 * 
 * @author Chris Schneider
 * 
 * @ORM\Entity
 * @ORM\Table(name="tbl_category")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap( {"user" = "Brainapp\UserBundle\Entity\UserEntities\UserCategory", "group" = "Brainapp\UserBundle\Entity\GroupEntities\GroupCategory"} )
 * @UniqueEntity(
 * 		fields={"categoryName","ownerId"},
 * 		errorPath="categoryName",
 * 		message="This categoryName is already used by the user."
 * )
 */
abstract class AbstractCategory
{
    
	//Variablen
	/**
	 * @ORM\Id
	 * @ORM\Column(name="categoryId", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $categoryId;
	
	/**
	 * @ORM\Column(name="categoryName", type="string")
	 * @Assert\NotBlank()
	 */
	protected $categoryName;
	/**
	 * @ORM\Column(name="parentCategoryId", type="integer", nullable=true, options={"default":null})
	 */
	protected $parentCategoryId;
	
	protected $ownerId;
	
	//Konstruktor
	public function __construct($categoryName, $parentCategoryId=null)
	{
		$this->categoryName = $categoryName;
		
		if(!(null==$parentCategoryId))
		{
			$this->parentCategoryId=$parentCategoryId;
		}		
	}
	
	
	//Abstrakte Methoden
	public abstract function getOwnerId();
	public abstract function setOwnerId($ownerId);
	
	//getter und setter
	public function getCategoryId()
	{
		return $this->categoryId;
	}
	public function setParentCategoryId($parentCategoryId)
	{
		$this->parentCategoryId = $parentCategoryId;
		return $this;
	}
	public function getCategoryName()
	{
		return $this->categoryName;
	}
	public function setCategoryName($categoryName)
	{
		$this->categoryName = $categoryName;
		return $this;
	}
	public function getIsSubCategory() {
		return ( ($this->parentCategoryId == null) ? false : true );
	}
	public function getParentCategoryId() {
		return $this->parentCategoryId;
	}
}
