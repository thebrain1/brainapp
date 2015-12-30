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
abstract class AbstractUserBudgetFormType extends AbstractType
{
	private $ownerId;
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		$this->setOwnerId($options['attr']['ownerId']);
		
		$builder->add("budgetName", "text", array('label' => 'Name',
                                                  'attr' => array('class' => 'form-control',
                                                                  'placeholder' => 'Name',
                                                                  'aria-describedby' => 'sizing-addon2')))
                ->add("budgetComment", "text", array('label' => 'Kommentar',
                                                     'attr' => array('class' => 'form-control',
                                                                     'placeholder' => 'Kommentar',
                                                                     'aria-describedby' => 'sizing-addon2'),
                                                     'required' => false))
                ->add("budgetValue", "number", array('label' => 'Betrag',
                                                    'attr' => array('class' => 'form-control',
                                                                    'placeholder' => 'Betrag',
                                                                    'aria-describedby' => 'sizing-addon2')))
                ->add("category", "entity", array('class' => 'Brainapp\CoreBundle\Entity\UserEntities\UserCategory',
                                                  'choice_label' => 'categoryName',
                                                  'query_builder' => function (EntityRepository $er) {
                                                                        $queryBuilder = $er->createQueryBuilder('c');
                                                                        $expr = $queryBuilder->expr();
                                                                        
                                                                        return $queryBuilder->add('where', $expr->andX($expr->eq('c.ownerId', $this->getOwnerId() )
                                                                                                                       /*$expr->isNotNull('c.parentCategory')*/))
                                                                                            ->orderBy('c.categoryName', 'ASC');            
                                                                     },
                                                  'choices_as_values' => true,
                                                  'group_by' => function($val, $key, $index) {
                                                                    $parentCat = $val->getParentCategory();
                                                                    
                                                                    if($parentCat != null)
                                                                    {
                                                                       return 'Unterkategorien zu "' . $parentCat->getCategoryName() . '"';
                                                                    }
                                                                    else
                                                                    {
                                                                       return "Hauptkategorien";
                                                                    }                                                    	
                                                                },
                                                  //'attr' => array('class' => 'selectpicker',
                                                   	                /*'multiple' => "multiple"*/))
                ->add("account", "entity", array('class' => 'Brainapp\CoreBundle\Entity\UserEntities\UserAccount',
                                                 'choice_label' => 'accountName',
                                                 'query_builder' => function (EntityRepository $er) {
                                                                       $queryBuilder = $er->createQueryBuilder('a');
                                                                       $expr = $queryBuilder->expr();
                                                                        
                                                                       return $queryBuilder->add('where', $expr->eq( 'a.ownerId', $this->getOwnerId() ))
                                                                                           ->orderBy('a.accountName', 'ASC');
                                                                    },
                                                 'choices_as_values' => true))
                ->add("resetPeriod", "choice", array('choices' => array("NO_SELECTED_PERIOD" => "nichts ausgewählt",
                		                                                "WEEKLY" => "jede Woche",
                		                                                "MONTHLY" => "jeder Monat"),
                		                             'attr' => ['class' => 'select-resetPeriod']))
                ->add("resetTriggerDate", "choice", ['choices' => [ 'NO_SELECTED_TRIGGER_DATE' => "nichts ausgewählt"],
                		                             'attr' => ['class' => 'select-resetTriggerDate']]
                     )
                ->add("id", "hidden")
                ->add('save', 'submit', array('label' => 'Speichern',
                                              'attr' => array('class' => 'btn btn-default btn-save-userbudgetvorlage')));
                
                $builder->get('resetTriggerDate')->resetViewTransformers();
	}
	
	abstract public function getName();
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Brainapp\CoreBundle\Entity\UserEntities\UserBudgetVorlage',
				'allow_extra_fields' => true,
		));
	}
	
	private function setOwnerId($ownerId)
	{
		$this->ownerId = $ownerId;
	}
	
	protected function getOwnerId()
	{
		if($this->ownerId != null)
		{
			return $this->ownerId;
		}		
	}
}