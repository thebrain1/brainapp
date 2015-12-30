<?php

namespace Brainapp\CoreBundle\Controller\Dashboard;

use Brainapp\CoreBundle\Controller\AbstractController;
use Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung;
use Brainapp\CoreBundle\Entity\UserEntities\BuchungEinnahme;
use Brainapp\CoreBundle\Entity\UserEntities\BuchungAusgabe;
use Brainapp\CoreBundle\Entity\UserEntities\BuchungUmbuchung;
use Brainapp\CoreBundle\Form\BuchungForm\CreateBuchungFormType;
use Brainapp\CoreBundle\Form\BuchungForm\CreateBuchungUmbuchungFormType;
use Brainapp\CoreBundle\Form\BuchungForm\EditBuchungFormType;
use Brainapp\CoreBundle\Form\BuchungForm\EditBuchungUmbuchungFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * 
 * @author Chris Schneider
 *
 */
class DashboardBuchungController extends AbstractController
{
	public function showBuchungenAction(Request $request)
	{
		$buchungRep = $this->getBuchungRep();
		
		$userId = $this->getUserId();
		$buchungen = $buchungRep->getBuchungenByOwnerId($userId);
		
		return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:showBuchungen.html.twig",
	                         $this->concatWithUserDataArray(array("buchungen" => $buchungen)));
	}
	
	public function showBuchungenWithoutCategoryAction(Request $request)
	{
		$buchungRep = $this->getBuchungRep();
	
		$userId = $this->getUserId();
		$buchungen = $buchungRep->getBuchungenByOwnerIdWithCategoryEqualToNull($userId);
	
		return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:showBuchungenWithoutCategory.html.twig",
			   $this->concatWithUserDataArray(array("buchungen" => $buchungen)));
	}
	
	public function createEinnahmeAction(Request $request)
	{
		$einnahme = new BuchungEinnahme();
		
		$form = $this->createForm(new CreateBuchungFormType(), $einnahme, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
	
		$form->handleRequest($request);
	
		if( $form->isValid() )
		{
			$buchungRep = $this->getBuchungRep();
			$buchungRep->storeBuchung($einnahme);
				
			return $this->redirectToRoute('show_buchungen');
		}
	
		return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:createBuchungEinnahme.html.twig",
				array("mask_buchung" => $form->createView()));
	}
	
	public function createAusgabeAction(Request $request)
	{
		$ausgabe = new BuchungAusgabe();
		
		$form = $this->createForm(new CreateBuchungFormType(), $ausgabe, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
		
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$buchungRep = $this->getBuchungRep();
			$buchungRep->storeBuchung($ausgabe);
		
			return $this->redirectToRoute('show_buchungen');
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:createBuchungAusgabe.html.twig",
				array("mask_buchung" => $form->createView()));
		
	}
	
	public function createUmbuchungAction(Request $request)
	{
		$umbuchung = new BuchungUmbuchung();
		
		$form = $this->createForm(new CreateBuchungUmbuchungFormType(), $umbuchung, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
		
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$buchungEinnahmeFromUmbuchung = $umbuchung->getEinnahme();
			
			$buchungRep = $this->getBuchungRep();
			$buchungRep->storeBuchung($buchungEinnahmeFromUmbuchung);
			$buchungRep->storeBuchung($umbuchung);
			
			return $this->redirectToRoute('show_buchungen');
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:createBuchungUmbuchung.html.twig",
				array("mask_buchung" => $form->createView()));
	}
	
	public function editBuchungEinnahmeAction(Request $request)
	{
		$buchungEinnahme = new BuchungEinnahme();
		
		$form = $this->getEditMaskForm($buchungEinnahme);
		
		$form->handleRequest($request);
		
		if( $form->isValid() )
		{
			$this->getBuchungRep()
			     ->updateBuchung($buchungEinnahme);
		
			return $this->redirectToRoute('show_buchungen');
		}
		
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews:editBuchung.html.twig",
				             array("mask_buchung" => $form->createView()));
	}
	
	public function editBuchungAusgabeAction(Request $request)
	{
		$buchungAusgabe = new BuchungAusgabe();
	
		$form = $this->getEditMaskForm($buchungAusgabe);
	
		$form->handleRequest($request);
	
		if( $form->isValid() )
		{
			$this->getBuchungRep()
			     ->updateBuchung($buchungAusgabe);
	
			return $this->redirectToRoute('show_buchungen');
		}
	
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews:editBuchung.html.twig",
				             array("mask_buchung" => $form->createView()));
	}
	
	public function editBuchungUmbuchungAction(Request $request)
	{
		$buchungUmbuchung = new BuchungUmbuchung();
	
		$form = $this->getEditMaskForm($buchungUmbuchung);
	
		$form->handleRequest($request);
	
		if( $form->isValid() )
		{
			$this->getBuchungRep()
			     ->updateBuchung($buchungUmbuchung);
	
			return $this->redirectToRoute('show_buchungen');
		}
	
		return $this->render("BrainappCoreBundle:Dashboard/UserAccountViews:editBuchungUmbuchung.html.twig",
				             array("mask_buchung" => $form->createView()));
	}
	
	private function getEditMaskForm(AbstractBuchung $instance)
	{	
		$form = null;
		
		if($instance instanceof BuchungUmbuchung)
		{
			$form = $this->createForm(new EditBuchungUmbuchungFormType(), $instance, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
		}
		else
		{
			$form = $this->createForm(new EditBuchungFormType(), $instance, array( "attr" => array("ownerId" => $this->getUserId() ) ) );
		}
		
		return $form;
	}
	
	public function getEditMaskAsHtmlAction(Request $request)
	{
		$buchungId = $request->get('id');
		
		$instance = $this->getBuchungRep()->getBuchungById($buchungId);
		
		if(is_null($instance))
		{
			throw new HttpException(400,"Die Buchung mit der ID=" . $buchungId . " existiert nicht!");
		}
		
		$form = $this->getEditMaskForm($instance);
		
		if($instance instanceof BuchungUmbuchung)
		{
			return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:editBuchungUmbuchung.html.twig",
			                     array("mask_buchung" => $form->createView(),
			                     	   "routeToTake" => "edit_buchung_umbuchung",
			                     ));
		}
		else if($instance instanceof BuchungEinnahme)
		{
			return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:editBuchung.html.twig",
				                 array("mask_buchung" => $form->createView(),
				                 	   "routeToTake" => "edit_buchung_einnahme",
				                 ));
		}
		else if($instance instanceof BuchungAusgabe)
		{
			return $this->render("BrainappCoreBundle:Dashboard/BuchungViews:editBuchung.html.twig",
					array("mask_buchung" => $form->createView(),
						  "routeToTake" => "edit_buchung_ausgabe",
					));
		}
		else
		{
			throw new HttpException(400, "Der Typ " . gettype($instance) . " wird nicht unterstützt.");
		}
	}
	
	public function deleteBuchungAction(Request $request)
	{
		$id = $request->request->get('#modalMaskDeleteBuchung_ff_id');
		
		$buchungRep = $this->getBuchungRep();
		
		$buchung = $buchungRep->getBuchungById($id);
		
		$gegenBuchung = null;
		
		//wenn $buchung eine eine Umbuchung ist, sollte sie immer eine Gegenbuchung haben, damit die "Bilanz" ausgeglichen bleibt
		//die Gegenrichtung (wenn also eine Einnahme = Gegenbuchung gelöscht wird) ist durch einen ON_DELETE_CASCADE-Constraint realisiert!
		if($buchung instanceof BuchungUmbuchung)
		{
			$gegenBuchung = $buchung->getEinnahme();
			
			if(is_null($gegenBuchung))
			{
				$this->get('logger')->info("WARNUNG: Die Umbuchung mit der ID=" . $buchung->getId() . " hat keine Gegenbuchung (Einnahme)!");
			}
		}
		
		if(!is_null($gegenBuchung))
		{
			$buchungRep->deleteUmbuchungWithEinnahme($buchung, $gegenBuchung);
		}
		else 
		{
			$buchungRep->deleteBuchung($buchung);
		}
	
		return $this->redirectToRoute('show_buchungen');
	}
	
	private function getBuchungRep()
	{
		$em = $this->getDoctrine()->getManager();
		return $em->getRepository('Brainapp\CoreBundle\Entity\AbstractEntities\AbstractBuchung');
	}
}