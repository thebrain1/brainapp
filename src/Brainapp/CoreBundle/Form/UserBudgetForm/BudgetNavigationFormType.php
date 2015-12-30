<?php

namespace Brainapp\CoreBundle\Form\UserBudgetForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 
 * @author Chris Schneider
 *
 */
class BudgetNavigationFormType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("previousMonth", "submit", array("attr" => array("class" => "btn btn-default"),
				                                       "label" => "Vorheriger Monat"))
		        ->add("nextMonth","submit", array("attr" => array("class" => "btn btn-default"),
				                                  "label" => "Nächster Monat"))
		        ->add("month","text");
	}
	
	public function getName()
	{
		"budgetNavigationForm";
	}
}