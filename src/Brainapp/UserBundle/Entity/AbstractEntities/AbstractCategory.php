<?php

namespace Brainapp\UserBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diese Klasse repräsentiert eine Kategorie, entweder die einer Gruppe oder eines (persönliche) des Users.
 * @ORM\Entity
 * @ORM\Table(name="tbl_category")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap( {"user" = "Brainapp\UserBundle\Entity\UserEntities\UserCategory", "group" = "Brainapp\UserBundle\Entity\GroupEntities\GroupCategory"} )
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
	 * @ORM\Column(name="categoryName", type="string", unique=true)
	 */
	protected $categoryName;
	/**
	 * @ORM\Column(name="parentCategoryId", type="integer", nullable=true, options={"default":null})
	 */
	protected $parentCategoryId;
	
	//Konstruktor
	public function __construct($categoryId,$categoryName, $parentCategoryId=null)
	{
		$this->categoryId = $categoryId;
		$this->categoryName = $categoryName;
		
		if(!(null==$parentCategoryId))
		{
			$this->parentCategoryId=$parentCategoryId;
		}		
	}
	
	
	//Abstrakte Methoden
	public abstract function getOwnerId();
	
	
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
