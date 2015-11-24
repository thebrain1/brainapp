<?php

namespace Brainapp\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
class UserCategoryForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("categoryName", "text", array('label' => 'Name',
                                                    'attr' => array('class' => 'form-control',
                                                                    'placeholder' => 'Name',
                                                                    'aria-describedby' => 'sizing-addon2')))
                ->add('save', 'submit', array('label' => 'Speichern',
                                              'attr' => array('class' => 'btn btn-default')));
	}
	
	public function getName()
	{
		return "userCategoryForm";
	}
}