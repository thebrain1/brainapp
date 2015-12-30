<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Doctrine\ORM\EntityRepository;
use Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * UserBudgetVorlageRepository
 * 
 * @author Chris Schneider
 */
class UserBudgetVorlageRepository extends EntityRepository
{
	
	private function getClassLogPrefix()
	{
		return "UserBudgetVorlageRepository::";
	}
	
	public function getUserBudgetVorlagenByOwnerId($ownerId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserBudgetVorlagenByOwnerId::";
		
		if(!is_null($ownerId))
		{
			$em = $this->getEntityManager();
			$userAccRep =  $em->getRepository('Brainapp\CoreBundle\Entity\UserEntities\UserAccount');;
			
			$userAccounts = $userAccRep->getUserAccountsByOwnerId($ownerId);
			
			$queryBuilder = $em->createQueryBuilder();
			$queryBuilder->select(array('b','a'))
			             ->from('Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage','b')
			             ->join('b.account','a')
			             ->add('where',$queryBuilder->expr()->eq('a.ownerId',$ownerId))
			             ->orderBy('b.budgetName');
			
			$query = $queryBuilder->getQuery();
			
			return $query->getResult();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'ownerId' is null");
		}
	}
	
	public function storeBudgetVorlage(UserBudgetVorlage $budgetVorlage)
	{
		$logPrefix = $this->getClassLogPrefix() . "storeBudgetVorlage::";
		
		if(!is_null($budgetVorlage))
		{
			$em = $this->getEntityManager();
			$em->persist($budgetVorlage);
			$result = $em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'budgetVorlage' is null");
		}
	}
	
	public function getUserBudgetVorlageById($id)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserBudgetVorlageById::";
		
		if(!is_null($id))
		{
			$result = $this->findOneById($id);
			
			if(!is_null($result))
			{
				return $result;
			}
			else
			{
				throw new HttpException(400, $logPrefix . "Die UserBudgetVorlage mit der ID=" . $id . " existiert nicht.");
			}
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'id' is null");
		}
	}
	
	public function updateUserBudgetVorlage(UserBudgetVorlage $budgetVorlage)
	{
	
		$logPrefix = $this->getClassLogPrefix() . "updateUserBudgetVorlage::";
	
		if(!is_null($budgetVorlage))
		{
			$id = $budgetVorlage->getId();
				
			$localUserBudgetVorlage = $this->getUserBudgetVorlageById($id);
				
			$em = $this->getEntityManager();				
			$em->merge($budgetVorlage);
			$em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'budgetVorlage' is null");
		}
	}
	
	public function deleteUserBudgetVorlageById($id)
	{
		$logPrefix = $this->getClassLogPrefix() . "deleteUserBudgetVorlageById::";
		
		if(!is_null($id))
		{
			$localUserBudgetVorlage = $this->getUserBudgetVorlageById($id);
			
			$em = $this->getEntityManager();
			$em->remove($localUserBudgetVorlage);
			$em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'id' is null");
		}
	}
}
