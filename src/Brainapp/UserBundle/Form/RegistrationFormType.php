<?php

namespace Brainapp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType 
{
	public function buildForm(FormBuilderInterface $builder, array $options) 
	{
		$builder
			->add('username', 'text', array(
					'label' => 'Benutzername',
					'attr' => array('placeholder' => 'Benutzername'),
					'label_attr' => array('class' => 'sr-only'),
					'constraints' => array(
							new NotBlank(array('message' => "Geben Sie einen Benutzernamen an")),
							new Length(array('min' => 4, 'minMessage' => "Der Benutzername ist zu kurz. Mindestens {{ limit }} Zeichen lang"))
					)
			))
			->add('email', 'email', array(
					'label' => 'E-Mail Adresse',
					'attr' => array('placeholder' => 'E-Mail Adresse'),
					'label_attr' => array('class' => 'sr-only'),
					'constraints' => array(
							new NotBlank(array('message' => "Geben Sie eine E-Mail Adresse an")),
							new Email(array('message' => "Geben Sie eine gültige E-Mail Adresse an"))
					)
			))
			->add('plainPassword', 'repeated', array(
				'type' => 'password',
				'first_options' => array (
						'label' => 'Passwort' ,
						'attr' => array('placeholder' => 'Passwort'),
						'label_attr' => array('class' => 'sr-only')
				),
				'second_options' => array (
						'label' => 'Passwort wiederholen',
						'attr' => array('placeholder' => 'Passwort wiederholen'),
						'label_attr' => array('class' => 'sr-only')
				),
				'invalid_message' => 'Die eingegebenen Passwörter stimmen nicht überein!', 
				'constraints' => array(
						new NotBlank(array('message' => "Geben Sie ein Passwort an")),
						new Length(array('min' => 8, 'minMessage' => "Ihr Passwort ist zu kurz. Mindestens {{ limit }} Zeichen lang"))
				)
			))
			->add('submit', 'submit', array(
					'label' => 'Registrieren!',
					'attr' => array('class' => 'btn-info btn-block'),
			));
	}
	
	public function configureOptions(OptionsResolver $resolver) 
	{
		$resolver->setDefaults ( array (
				'data_class' => 'Brainapp\UserBundle\Entity\User',
				'intention' => 'registration' 
		) );
	}
	
// 	public function getParent() 
// 	{
// 		return 'fos_user_registration';
// 	}
	
	public function getName() 
	{
		return 'brainapp_user_registration';
	}
}