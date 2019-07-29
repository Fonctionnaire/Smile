<?php


namespace App\Controller\Admin;


use App\Entity\Quote;
use App\Form\QuoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuoteAdminController extends AbstractController
{

    /**
     * @Route("/a-s/all-quotes", name="admin_all_quotes", methods={"GET"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function allQuotes()
    {
        $em = $this->getDoctrine()->getRepository(Quote::class);
        $quotes = $em->findAll();
        return $this->render('admin/allQuotesAdmin.html.twig', [
            'quotes' => $quotes
        ]);
    }

    /**
     * @Route("/a-s/add-quote", name="admin_add_quote", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function addQuote(Request $request)
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();
            $this->addFlash('success', 'La citation a bien été ajouté !');
            return $this->redirectToRoute('admin_all_quotes');
        }
        return $this->render('admin/addQuoteAdmin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/a-s/edit-quote/{id}", name="admin_edit_quote", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function editQuote(Request $request, Quote $quote)
    {
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success','La quote a bien été édité !');

            return $this->redirectToRoute('admin_all_quotes');
        }
        return $this->render('admin/editQuoteAdmin.html.twig', [
            'quote' => $quote,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/a-s/delete-quote/{id}", name="admin_delete_quote", methods={"POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function deleteQuote(Quote $quote)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($quote);
        $em->flush();
        $this->addFlash('success', 'La quote a bien été supprimé !');

        return $this->redirectToRoute('admin_all_quotes');
    }
}