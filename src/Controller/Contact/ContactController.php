<?php


namespace App\Controller\Contact;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/{_locale}/contact", name="contact", methods={"GET", "POST"}, defaults={"_locale"="fr"}, requirements={"_locale"="%app.locales%"})
     */
    public function contact(Request $request, ContactMail $contactMail)
    {
        $locale = $request->getLocale();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $contactMail->sendContactMail($contact);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('contact-success', 'Votre message a bien été envoyé !');

            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/contact.html.twig', [
            'locale' => $locale,
            'form' => $form->createView()
        ]);
    }
}