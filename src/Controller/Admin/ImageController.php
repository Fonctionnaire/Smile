<?php


namespace App\Controller\Admin;


use App\Entity\Image;
use App\Form\ImageType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ImageController extends AbstractController
{

    /**
     * @Route("/a-s/add-image", name="admin_add_image", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function addImage(Request $request, FileUploader $fileUploader)
    {
        $img = new Image();
        $form =$this->createForm(ImageType::class, $img);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $imgFile = $form['image']->getData();
            $fileName = $fileUploader->upload($imgFile);
            $img->setImageName($fileName);
            dd($img);
            $em->persist($img);
            $em->flush();
            $this->addFlash('success', 'L\'image a bien été ajouté !');

            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/image/addImage.html.twig', [
            'form' => $form->createView()
        ]);
    }
}