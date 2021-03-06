<?php

namespace Brainapp\CoreBundle\Form\AccountForm;

use Brainapp\CoreBundle\Form\AccountForm\AbstractUserAccountFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class EditUserAccountFormType extends AbstractUserAccountFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add("accountStartValue", "number", array('label' => 'Startsaldo',
			                                               'attr' => array('class' => 'form-control',
			                                                               'placeholder' => 'Startsaldo',
			                                                               'aria-describedby' => 'sizing-addon2',
			                                                               'disabled' => 'disabled')));
	}
	
	public function getName()
	{
		return "editUserAccountForm";
	}
}