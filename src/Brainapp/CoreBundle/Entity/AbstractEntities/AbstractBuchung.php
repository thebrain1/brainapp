<?php

namespace Brainapp\CoreBundle\Entity\AbstractEntities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diese Klasse repräsentiert eine Konto, entweder das einer Gruppe oder eines Users.
 * 
 * @author Chris Schneider
 * 
 * @ORM\Entity(repositoryClass="Brainapp\CoreBundle\Entity\UserEntities\BuchungRepository")
 * @ORM\Table(name="tbl_buchung")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap( {"einnahme" = "Brainapp\CoreBundle\Entity\UserEntities\BuchungEinnahme", "ausgabe" = "Brainapp\CoreBundle\Entity\UserEntities\BuchungAusgabe", "umbuchung" = "Brainapp\CoreBundle\Entity\UserEntities\BuchungUmbuchung"} )
 */
abstract class AbstractBuchung
{
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @ORM\Column(name="title", type="string", nullable = false)
	 */
	protected $title;
	/**
	 * @ORM\Column(name="comment", type="string", nullable = true)
	 */
	protected $comment;
	/**
	 * @ORM\Column(name="date", type="date", nullable = true)
	 */
	protected $date;
	/**
	 * @ORM\Column(name="value", type="float", nullable = false)
	 */
	protected $value;
    /**
     * @ORM\ManyToOne(targetEntity="Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory")
     * @ORM\JoinColumn(name="category", referencedColumnName="categoryId", nullable=true, onDelete="CASCADE")
     */
	protected $category;
	/**
	 * @ORM\ManyToOne(targetEntity="Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount")
	 * @ORM\JoinColumn(name="account", referencedColumnName="accountId", nullable=true, onDelete="CASCADE")
	 */
	protected $account;
	
	
	public function __construct()
	{
		$this->setDate(new \DateTime());
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
	public function getComment() {
		return $this->comment;
	}
	public function setComment($comment) {
		$this->comment = $comment;
		return $this;
	}
	public function getDate() {
		return $this->date;
	}
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}
	public function getValue() {
		return $this->value;
	}
	public function setValue($value) {
		$this->value = round($value, 2);
		return $this;
	}
	public function getCategory() {
		return $this->category;
	}
	public function setCategory($category) {
		$this->category = $category;
		return $this;
	}
	public function getAccount() {
		return $this->account;
	}
	public function setAccount($account) {
		$this->account = $account;
		return $this;
	}
	public function getTargetAccount()
	{
		return null;
	}
	public function setTargetAccount($targetAccount)
	{
	
	}
}
