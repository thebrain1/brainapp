<?php

namespace Brainapp\CoreBundle\Form\BuchungForm;

use Brainapp\CoreBundle\Form\BuchungForm\EditBuchungFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * 
 * @author Chris Schneider
 *
 */
class EditBuchungUmbuchungFormType extends EditBuchungFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add("targetAccount", "entity", array('class' => 'Brainapp\CoreBundle\Entity\UserEntities\UserAccount',
                                                       'choice_label' => 'accountName',
                                                       'query_builder' => function (EntityRepository $er) {
                                                                             $queryBuilder = $er->createQueryBuilder('a');
                                                                             $expr = $queryBuilder->expr();
                                                                              
                                                                             return $queryBuilder->add('where', $expr->eq( 'a.ownerId', $this->getOwnerId() ))
                                                                                                 ->orderBy('a.accountName', 'ASC');
                                                                          },
                                                       'choices_as_values' => true));
	}
	
	public function getName()
	{
		return "editBuchungUmbuchungForm";
	}
}