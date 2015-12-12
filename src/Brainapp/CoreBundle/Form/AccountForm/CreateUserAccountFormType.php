<?php

namespace Brainapp\CoreBundle\Form\AccountForm;

use Brainapp\CoreBundle\Form\AccountForm\AbstractUserAccountFormType;

/**
 * 
 * @author Chris Schneider
 *
 */
class CreateUserAccountFormType extends AbstractUserAccountFormType
{
	public function getName()
	{
		return "createUserAccountForm";
	}
}