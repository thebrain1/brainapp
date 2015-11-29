<?php

namespace Brainapp\CoreBundle\Form;

use Brainapp\CoreBundle\Form\UserCategoryForm;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class SubUserCategoryForm extends UserCategoryForm
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		parent::buildForm($builder, $options);
		
		$builder->add("parentCategoryId", "hidden");
	}
	
	public function getName()
	{
		return "subUserCategoryForm";
	}
}