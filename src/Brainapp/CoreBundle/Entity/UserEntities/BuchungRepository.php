<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractAccount;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * BuchungRepository
 * 
 * @author Chris Schneider
 */
class BuchungRepository extends EntityRepository
{
	
	private function getClassLogPrefix()
	{
		return "BuchungRepository::";
	}
	
	public function getBuchungenByOwnerId($ownerId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getBuchungenByOwnerId::";
	
		if(!is_null($ownerId))
		{
			$em = $this->getEntityManager();
			
			$queryBuilder = $em->createQueryBuilder();
			$queryBuilder->select(array('b','a'))
			             ->from('Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung','b')
			             ->join('b.account','a')
			             ->add('where',$queryBuilder->expr()->eq('a.ownerId',$ownerId))
			             ->orderBy('b.date, b.id');
				
			$query = $queryBuilder->getQuery();
				
			return $query->getResult();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'ownerId' is null");
		}
	}
	
	public function getBuchungenByOwnerIdWithCategoryEqualToNull($ownerId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getBuchungenByOwnerIdWithCategoryEqualToNull::";
	
		if(!is_null($ownerId))
		{
			$em = $this->getEntityManager();
				
			$queryBuilder = $em->createQueryBuilder();
			
			$expr = $queryBuilder->expr();
			
			$queryBuilder->select(array('b','a'))
			             ->from('Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung','b')
			             ->join('b.account','a')
			             ->where($expr->andX($expr->eq('a.ownerId',$ownerId),
			             		             $expr->isNull('b.category')))
			             ->orderBy('b.date, b.id');
	
			$query = $queryBuilder->getQuery();
	
			return $query->getResult();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'ownerId' is null");
		}
	}
	
	public function getBuchungById($id)
	{
		$logPrefix = $this->getClassLogPrefix() . "getBuchungById::";
		
		if(!is_null($id))
		{
			return $this->findOneById($id);
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'id' is null");
		}
	}
	
	public function getSumOfBuchungValuesByAccount(AbstractAccount $account)
	{
		$logPrefix = $this->getClassLogPrefix() . "getSumOfBuchungValuesByAccount::";
		
		if(!is_null($account))
		{
			$accountId = $account->getAccountId();
			
			$dql = "SELECT SUM(b.value) AS balance " .
			       "FROM Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung b ".
                   "WHERE b.account = ?1";
			
			
			
			$em = $this->getEntityManager();
				
			$result = $em->createQuery($dql)
			             ->setParameter(1, $accountId)
			             ->getSingleScalarResult();
			
			return $result;
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'account' is null");
		}
	}
	
	public function getSumOfBuchungValuesByAccountAndDatePairs(AbstractAccount $account, array $beginnPair = null, array $endePair = null)
	{
		$logPrefix = $this->getClassLogPrefix() . "getSumOfBuchungValuesByAccountAndDatePairs::";
		
		//PRÜFUNG
		if(is_null($account))
		{
			throw new HttpException(400, $logPrefix . "Parameter 'account' is null");
		}
		
		//LOGIK
		$accountId = $account->getAccountId();
			
		$dql = "SELECT SUM(b.value) AS balance " .
		       "FROM Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung b ".
		       "WHERE b.account = ?1 " . $this->buildQueryStringExtension($beginnPair, $endePair);
		
		//ERGEBNISSE
	    $em = $this->getEntityManager();
	     
	    $result = $em->createQuery($dql)
	                 ->setParameter(1, $accountId)
	                 ->getSingleScalarResult();
	    
	    return $result;
	}
	
	
	//<Chris Schneider, 28.12.2015, Summe von Buchungen zu einer Kategorie>
	public function getSumOfBuchungValuesByCategoryAndDatePairs(AbstractCategory $category, array $beginnPair = null, array $endePair = null)
	{
		$logPrefix = $this->getClassLogPrefix() . "getSumOfBuchungValuesByCategoryAndDatePairs::";
	
		//PRÜFUNG
		if(is_null($category))
		{
			throw new HttpException(400, $logPrefix . "Parameter 'category' is null");
		}
		
		//LOGIK
		$categoryId = $category->getCategoryId();
		
		$dql = "SELECT SUM(b.value) AS balance " .
		       "FROM Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung b ".
		       "JOIN Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory c " .
		       "WITH (b.category = c.categoryId)" .
		       "WHERE (b.category = ?1 OR c.parentCategory = ?1) " . $this->buildQueryStringExtension($beginnPair, $endePair);
				
		//ERGEBNISSE
		$em = $this->getEntityManager();
		
		$result = $em->createQuery($dql)
		             ->setParameter(1, $categoryId)
		             ->getSingleScalarResult();
		
		return $result;
	}
	//</Chris Schneider, 28.12.2015, Summe von Buchungen zu einer Kategorie>
	
	public function storeBuchung(AbstractBuchung $buchung)
	{
		$logPrefix = $this->getClassLogPrefix() . "storeBuchung::";
	
		if(!is_null($buchung))
		{
			$em = $this->getEntityManager();
			$em->persist($buchung);
			$result = $em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'buchung' is null");
		}
	
	}
	
	public function updateBuchung(AbstractBuchung $buchung)
	{
		$logPrefix = $this->getClassLogPrefix() . "updateBuchung::";
		
		if(!is_null($buchung))
		{
			$em = $this->getEntityManager();
			$em->merge($buchung);
			$em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'buchung' is null");
		}
	}
	
	public function deleteBuchung($buchung)
	{
		$logPrefix = $this->getClassLogPrefix() . "deleteBuchung::";
	
		if(!is_null($buchung))
		{
			$em = $this->getEntityManager();
			$em->remove($buchung);
			$em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'buchung' is null");
		}
	}
	
	/*
	 * Löscht eine Umbuchung mit ihrer dazugehörigen Einnahme; Um mit Transaktionen ( siehe em->flush() ) arbeiten zu können,
	 * wurde eine extra Funktion angelegt.
	 */
	public function deleteUmbuchungWithEinnahme(BuchungUmbuchung $umbuchung, BuchungEinnahme $einname)
	{
		$logPrefix = $this->getClassLogPrefix() . "deleteUmbuchungWithEinnahme::";
	
		if(is_null($umbuchung))
		{
			throw new HttpException(400, $logPrefix . "Parameter 'umbuchung' is null");
		}
		else if(is_null($einname))
		{
			throw new HttpException(400, $logPrefix . "Parameter 'einname' is null");
		}
		else 
		{
			$em = $this->getEntityManager();
			$em->remove($umbuchung);
			$em->remove($einname);
			$em->flush();//Transaktion
		}
	}
	
	private function checkDateOperatorThrowExceptionOnFailure($dateOperator)
	{
		$ALLOWED_OPERATORS = array("<=",">=","=","<",">");
		
		if(!is_null($dateOperator))
		{
			if(in_array($dateOperator, $ALLOWED_OPERATORS))
			{
				return true;
			}
			else
			{
				throw new HttpException(400, $logPrefix . "The value of parameter 'dateOperator' is invalid.");
			}
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'dateOperator' is null");
		}
	}
	
	private function buildQueryStringExtension(array $beginnPair = null, array $endePair = null)
	{
		$logPrefix = $this->getClassLogPrefix() . "buildQueryStringExtension::";
		
		//PRÜFUNG
		if( ( !is_null($beginnPair) ) && ( sizeof($beginnPair) != 2 ) )
		{
			throw new HttpException(400, $logPrefix . "Parameter 'beginnPair' is invalid.");
		}
		if( ( !is_null($endePair) ) && ( sizeof($endePair) != 2) )
		{
			throw new HttpException(400, $logPrefix . "Parameter 'endePair' is invalid.");
		}
		
		$dql = "";
		
		if(!is_null($beginnPair))
		{
			$beginnDatumOperator = $beginnPair[0];
		
			if($this->checkDateOperatorThrowExceptionOnFailure($beginnDatumOperator))
			{
				$beginnDatum = $beginnPair[1];
				$dql = $dql . "AND b.date " . $beginnDatumOperator . " '" . $beginnDatum . "' ";
			}
		}
		
		if(!is_null($endePair))
		{
			$endeDatumOperator = $endePair[0];
		
			if($this->checkDateOperatorThrowExceptionOnFailure($endeDatumOperator))
			{
				$endeDatum = $endePair[1];
				$dql = $dql . "AND b.date " . $endeDatumOperator . " '" . $endeDatum . "' ";
			}
		}
		
		return $dql;
	}
}
