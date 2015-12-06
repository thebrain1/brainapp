<?php

namespace Brainapp\CoreBundle\Form\UserCategoryForm;

use Brainapp\CoreBundle\Form\UserCategoryForm\AbstractUserCategoryFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class CreateUserSubCategoryForm extends AbstractUserCategoryFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add("parentCategoryId", "hidden");
	}
	
	public function getName()
	{
		return "createUserSubCategoryForm";
	}
}