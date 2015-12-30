<?php

namespace Brainapp\CoreBundle\Form\BuchungForm;

use Brainapp\CoreBundle\Form\BuchungForm\AbstractBuchungFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class EditBuchungFormType extends AbstractBuchungFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}
	
	public function getName()
	{
		return "editBuchungForm";
	}
}