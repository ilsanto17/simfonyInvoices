<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\invoiceRow;
use App\Entity\invoice;
use App\Form\invoiceType;
use DateTime;
use http\Env\Response;
use Symfony\Component\HttpFoundation\Request;

class invoiceController extends AbstractController
{
    
    /**
     * @Route("/form", name="invoice_form")
     */

    public function setInvoiceForm(Request $request){

        $invoiceRow = new invoiceRow();


        $form = $this->createForm(invoiceType::class, $invoiceRow, ['action' => $this->generateUrl('invoice_form')]);



        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoiceRow);
            $invoice = new Invoice();
            $invoice->setInvoiceNumber($invoiceRow->getInvoiceID());
            $invoice->setInvoiceDate(new \DateTime());
            $invoice->setClientID(1);
            $em->persist($invoice);
            $em->flush();
          
            return $this->redirectToRoute('success');

	
        }

        return $this->render('invoice_form/form.html.twig', [
            
            'form' => $form->createView()
        ]);


    }
   /**
 * @Route("/form/success", name="success")
 */ 
    public function Success()
{
	return $this->render('invoice_form/success.html.twig', [
		
	]);
}






}