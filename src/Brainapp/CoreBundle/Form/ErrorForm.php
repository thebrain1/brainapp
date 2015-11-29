<?php

namespace Brainapp\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class ErrorForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	}
	
	public function getName()
	{
		return "errorForm";
	}
}