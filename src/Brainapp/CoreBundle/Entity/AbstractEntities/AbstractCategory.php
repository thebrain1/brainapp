<?php

namespace Brainapp\CoreBundle\Entity\AbstractEntities;

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
 * @ORM\DiscriminatorMap( {"user" = "Brainapp\CoreBundle\Entity\UserEntities\UserCategory", "group" = "Brainapp\CoreBundle\Entity\GroupEntities\GroupCategory"} )
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
	 * @ORM\ManyToOne(targetEntity="Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory")
	 * @ORM\JoinColumn(name="parentCategory", referencedColumnName="categoryId", onDelete="CASCADE")
	 */
	protected $parentCategory;
	/**
	 * @ORM\Column(name="ownerId", type="integer"))
	 */
	protected $ownerId;
	
	//Konstruktor
	public function __construct($categoryName, $parentCategory=null)
	{
		$this->categoryName = $categoryName;
		
		if(!(null==$parentCategory))
		{
			$this->parentCategory=$parentCategory;
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
	public function setCategoryId($categoryId)
	{
 		$this->categoryId = $categoryId;
		return $this;
	}
	
	public function getParentCategory() {
		return $this->parentCategory;
	}
	public function setParentCategory($parentCategory)
	{
		$this->parentCategory = $parentCategory;
		return $this;
	}
	public function getParentCategoryId()
	{
		$localParentCategory = $this->getParentCategory();
		
		if($localParentCategory != null)
		{
			return $localParentCategory->getCategoryId();
		}
		else
		{
			return null;
		}
	}
	
	//Dummy-Funktion die von Symfony beim Submit einer Form benötigt wird
	//Aktuell wird die Form-Unterstützung von Symfony bei Kategorien nicht voll genutzt
	//Die Werte eines neuen Kategorie-Objects werden manuell aus dem Request bezogen
	//TODO: bei Bedarf auf Symfony-Formuntersützung umstellen
	public function setParentCategoryId($parentCategoryId){}
	
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
		return ( ($this->parentCategory == null) ? false : true );
	}
}
