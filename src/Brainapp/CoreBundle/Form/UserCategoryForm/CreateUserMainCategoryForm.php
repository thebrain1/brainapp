<?php

namespace Brainapp\CoreBundle\Form\UserCategoryForm;

use Brainapp\CoreBundle\Form\UserCategoryForm\AbstractUserCategoryFormType;

/**
 * 
 * @author Chris Schneider
 *
 */
class CreateUserMainCategoryForm extends AbstractUserCategoryFormType
{
	public function getName()
	{
		return "createUserMainCategoryForm";
	}
}