<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Brainapp\UserBundle\Entity\User;

/**
 * 
 * @author Chris Schneider
 *
 */
abstract class AbstractController extends Controller
{
	
	private $userData=null;
		
	private function getUserData()
    {
    	
    	if($this->userData == null)
    	{
    		$user = $this->getUser();
    		
    		$userId = $user->getId();
    		$username = $user->getUsername();
    		
    		$this->userData = array	("userid" => $userId,
    				                 "username" => $username
    		                        );
    	}
    	
    	return $this->userData;
    }
    
    protected function concatWithUserDataArray($array=null)
    {
    	if($array == null)
    	{
    		return $this->getUserData();
    	}
    	
    	return array_merge
    	(
    		$this->getUserData(),
    		$array
    	);
    }
    
    protected function getUserId()
    {
    	return $this->getUserData()["userid"];
    }
    
    protected function getUserName()
    {
    	return $this->getUserData()["username"];
    }
}
