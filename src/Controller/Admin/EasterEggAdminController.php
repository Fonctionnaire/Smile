<?php


namespace App\Controller\Admin;


use App\Entity\EasterEgg;
use App\Form\EasterEggType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EasterEggAdminController extends AbstractController
{

    /**
     * @Route("/a-s/all-eastereggs", name="admin_all_eastereggs", methods={"GET"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function allEasterEggs()
    {
        $em = $this->getDoctrine()->getRepository(EasterEgg::class);
        $easterEggs = $em->findAll();
        return $this->render('admin/allEasterEggsAdmin.html.twig', [
            'easterEggs' => $easterEggs
        ]);
    }

    /**
     * @Route("/a-s/add-eastereggs", name="admin_add_easteregg", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function addEasterEggs(Request $request)
    {
        $ee = new EasterEgg();
        $form = $this->createForm(EasterEggType::class, $ee);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ee);
            $em->flush();
            $this->addFlash('success', 'L\'easter egg a bien été ajouté !');

            return $this->redirectToRoute('admin_all_eastereggs');
        }
        return $this->render('admin/addEasterEggAdmin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/a-s/edit-easteregg/{id}", name="admin_edit_easteregg", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function editEasterEgg(EasterEgg $easterEgg, Request $request){
        $form = $this->createForm(EasterEggType::class, $easterEgg);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'L\'easter egg a bien été modifié !');

            return $this->redirectToRoute('admin_all_eastereggs');
        }
        return $this->render('admin/editEasterEggAdmin.html.twig', [
            'form' => $form->createView(),
            'easterEgg' => $easterEgg
        ]);
    }

    /**
     * @Route("/a-s/delete-easteregg/{id}", name="admin_delete_easteregg", methods={"POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function deleteEasterEgg(EasterEgg $easterEgg){
        $em = $this->getDoctrine()->getManager();
        $em->remove($easterEgg);
        $em->flush();
        $this->addFlash('success', 'L\'Easter Egg a bien été supprimé !');

        return $this->redirectToRoute('admin_all_eastereggs');
    }
}