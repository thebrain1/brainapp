<?php

namespace Brainapp\CoreBundle\Form\AccountForm;

use Brainapp\CoreBundle\Form\AccountForm\AbstractUserAccountFormType;

/**
 * 
 * @author Chris Schneider
 *
 */
class EditUserAccountFormType extends AbstractUserAccountFormType
{
	public function getName()
	{
		return "editUserAccountForm";
	}
}