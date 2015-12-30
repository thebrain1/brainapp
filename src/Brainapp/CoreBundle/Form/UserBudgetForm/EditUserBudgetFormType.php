<?php

namespace Brainapp\CoreBundle\Form\UserBudgetForm;

use Brainapp\CoreBundle\Form\UserBudgetForm\AbstractUserBudgetFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class EditUserBudgetFormType extends AbstractUserBudgetFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add('changingScope', 'choice', array('label' => 'Umfang',
		                                               'choices' => array('alle Budgets ändern',
		                                                                  /*'zukünftige Budget ändern'*/),//TODO
		                                               'multiple' => false,
		                                               ));
	}
	
	public function getName()
	{
		return 'editUserBudgetForm';
	}
}