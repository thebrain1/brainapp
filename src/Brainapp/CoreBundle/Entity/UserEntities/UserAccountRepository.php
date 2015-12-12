<?php

namespace Brainapp\CoreBundle\Entity\UserEntities;

use Brainapp\CoreBundle\Entity\UserEntities\UserAccount;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * UserAccountRepository
 * 
 * @author Chris Schneider
 */
class UserAccountRepository extends EntityRepository
{
	
	private function getClassLogPrefix()
	{
		return "UserAccountRepository::";
	}
	
	public function storeAccount(UserAccount $account)
	{
		$logPrefix = $this->getClassLogPrefix() . "storeAccount::";
	
		if($account != null)
		{
			$em = $this->getEntityManager();
			
			$this->setAllAccountsNonDefaultExceptFromParameterAccount($account);
			
			$em->persist($account);
			$result = $em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'account' is null");
		}
	
	}
	
	public function getUserAccountsByOwnerId($ownerId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserAccountsByOwnerId::";
	
		if($ownerId != null)
		{
			$queryBuilder = $this->createQueryBuilder('a');
			$expr = $queryBuilder->expr();
				
			$query = $queryBuilder->add('where', $expr->eq( 'a.ownerId', $ownerId ));
				
			return $query->getQuery()->getResult();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'ownerId' is null");
		}
	}
	
	public function getUserAccountByAccountId($accountId)
	{
		$logPrefix = $this->getClassLogPrefix() . "getUserAccountByAccountId::";
		
		if($accountId != null)
		{
			return $this->findOneByAccountId($accountId);
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'accountId' is null"); 
		}
	}
	
	public function deleteUserAccountByAccountId($accountId)
	{
		$logPrefix = $this->getClassLogPrefix() . "deleteUserAccountById::";
	
		if($accountId != null)
		{
			$userAcc = $this->getUserAccountByAccountId($accountId);
	
			if($userAcc != null)
			{
				$em = $this->getEntityManager();
				$em->remove($userAcc);
				$em->flush();
				 
				return true;
			}
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'accountId' is null");
		}
		 
		return false;
	}
	
	public function setAllAccountsNonDefaultExceptFromParameterAccount(UserAccount $account)
	{
		$logPrefix = $this->getClassLogPrefix() . "setAllAccountsNonDefaultExceptFromParameterAccount::";
		
		if($account != null)
		{
			if($account->getAccountIsDefaultAccount())
			{
				$queryBuilder = $this->createQueryBuilder('a');
				$expr = $queryBuilder->expr();
			
				$query = $queryBuilder->update()
				->set('a.accountIsDefaultAccount', $queryBuilder->expr()->literal(false))
				->add('where', $expr->andX($expr->eq('a.accountIsDefaultAccount', true),
						                   $expr->eq('a.ownerId', $account->getOwnerId())))
				->getQuery();
			        
				$query->execute();
			}
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'account' is null");
		}
	}
	
	public function editAccountUpdate(UserAccount $account)
	{
	
		$logPrefix = $this->getClassLogPrefix() . "editAccountUpdate::";
	
		if($account != null)
		{
			$accountId = $account->getAccountId();
			
			$localUserAcc = $this->getUserAccountByAccountId($accountId);
			
			$localUserAcc->setAccountName( $account->getAccountName() );
			$localUserAcc->setAccountStartValue( $account->getAccountStartValue() );
			$localUserAcc->setAccountIsDefaultAccount( $account->getAccountIsDefaultAccount() );
			
			$em = $this->getEntityManager();
			
			$this->setAllAccountsNonDefaultExceptFromParameterAccount($localUserAcc);
			
			$em->merge($localUserAcc);
			$em->flush();
		}
		else
		{
			throw new HttpException(400, $logPrefix . "Parameter 'account' is null");
		}
	}
}
