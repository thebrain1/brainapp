<?php

namespace Brainapp\CoreBundle\Form\UserCategoryForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
abstract class AbstractUserCategoryFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("categoryName", "text", array('label' => 'Name',
                                                    'attr' => array('class' => 'form-control',
                                                                    'placeholder' => 'Name',
                                                                    'aria-describedby' => 'sizing-addon2')))
                ->add("categoryId", "hidden")
                ->add('save', 'submit', array('label' => 'Speichern',
                                              'attr' => array('class' => 'btn btn-default')));
	}
	
	abstract public function getName();
}