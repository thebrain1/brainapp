<?php

namespace Brainapp\CoreBundle\Form\BuchungForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 
 * @author Chris Schneider
 *
 */
abstract class AbstractBuchungFormType extends AbstractType
{
	private $ownerId;
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$this->setOwnerId($options['attr']['ownerId']);
		
		$builder->add("title", "text", array('label' => 'Titel',
                                             'attr' => array('class' => 'form-control',
                                                             'placeholder' => 'Titel',
                                                             'aria-describedby' => 'sizing-addon2')))
                ->add("comment", "text", array('label' => 'Kommentar',
                                               'attr' => array('class' => 'form-control',
                                                               'placeholder' => 'Kommentar',
                                                               'aria-describedby' => 'sizing-addon2'),
                                               'required' => false))
                ->add("date", "date", array('label' => 'Datum',
                                            /*'attr' => array('class' => 'form-control',
                                                            'placeholder' => 'Datum',
                                                            'aria-describedby' => 'sizing-addon2'),*/))
                ->add("value", "number", array('label' => 'Betrag',
                                               'attr' => array('class' => 'form-control',
                                                               'placeholder' => 'Betrag',
                                                               'aria-describedby' => 'sizing-addon2')))
                ->add("category", "entity", array('class' => 'Brainapp\CoreBundle\Entity\AbstractEntities\AbstractCategory',
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
                ->add("id", "hidden")
                ->add('save', 'submit', array('label' => 'Speichern',
                                              'attr' => array('class' => 'btn btn-default btn-save-buchung')));
	}
	
	abstract public function getName();
	
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