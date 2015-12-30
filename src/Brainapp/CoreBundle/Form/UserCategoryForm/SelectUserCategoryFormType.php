<?php

namespace Brainapp\CoreBundle\Form\UserCategoryForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 
 * @author Chris Schneider
 *
 */
class SelectUserCategoryFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		$builder->add("categoryName")
                ->add("categoryId", "hidden");
		
// 		$builder->add("categoryName", "text", array('label' => 'Name',
//                                                     'attr' => array('class' => 'form-control',
//                                                                     'placeholder' => 'Name',
//                                                                     'aria-describedby' => 'sizing-addon2')))
//                 ->add("categoryId", "hidden");
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Brainapp\CoreBundle\Entity\UserEntities\UserCategory',
		));
	}
	
	public function getName()
	{
		return "selectUserCategoryForm";
	}
}