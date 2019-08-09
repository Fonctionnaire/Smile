<?php


namespace App\Controller\Admin;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactAdminController extends AbstractController
{

    /**
     * @Route("/a-s/contacts", name="admin_all_contacts", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function allContacts(ContactRepository $contactRepository)
    {
        $contacts = $contactRepository->findWaitingContacts();

        return $this->render('admin/allContactsAdmin.html.twig', [
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/a-s/view-contact/{id}", name="admin_view_contact", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function viewContact(Contact $contact)
    {

        return $this->render('admin/viewContactAdmin.html.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/a-s/validate-contact/{id}", name="admin_validate_contact", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function validateContact(Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $contact->setIsWaiting(false);
        $em->flush();
        $this->addFlash('success', 'Le message à bien été traité !');

        return $this->redirectToRoute('admin_all_contacts');
    }
}