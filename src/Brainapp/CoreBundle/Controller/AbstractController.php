<?php

namespace Brainapp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Brainapp\UserBundle\Entity\User;


abstract class AbstractController extends Controller
{
	private function getUserData()
    {
    	
    	$user = $this->getUser();
    	 
    	$userId = $user->getId();
    	$username = $user->getUsername();
    	
    	return array
    	(
     		"userid" => $userId,
     		"username" => $username
    	);
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
}
