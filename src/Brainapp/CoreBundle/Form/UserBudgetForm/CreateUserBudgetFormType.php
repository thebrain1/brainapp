<?php

namespace Brainapp\CoreBundle\Form\UserBudgetForm;

use Brainapp\CoreBundle\Form\UserBudgetForm\AbstractUserBudgetFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class CreateUserBudgetFormType extends AbstractUserBudgetFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	
	public function getName()
	{
		return "createUserBudgetForm";
	}
}