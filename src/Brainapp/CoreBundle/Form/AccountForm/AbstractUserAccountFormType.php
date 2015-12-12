<?php

namespace Brainapp\CoreBundle\Form\AccountForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Chris Schneider
 *
 */
abstract class AbstractUserAccountFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("accountName", "text", array('label' => 'Kontoname',
                                                    'attr' => array('class' => 'form-control',
                                                                    'placeholder' => 'Kontoname',
                                                                    'aria-describedby' => 'sizing-addon2')))
                ->add("accountStartValue", "number", array('label' => 'Startsaldo',
                                                           'attr' => array('class' => 'form-control',
                                                                           'placeholder' => 'Startsaldo',
                                                                           'aria-describedby' => 'sizing-addon2')))
                ->add("accountIsDefaultAccount", "checkbox", array('label' => 'ist Standardkonto',
                                                                   'required' => false))
                ->add("accountId", "hidden")
                ->add('save', 'submit', array('label' => 'Speichern',
                                              'attr' => array('class' => 'btn btn-default')));
	}
	
	abstract public function getName();
}