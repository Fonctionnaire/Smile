<?php


namespace App\Controller\Admin;


use App\Entity\Image;
use App\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ImageController extends AbstractController
{

    /**
     * @Route("/a-s/add-image", name="admin_add_image", methods={"GET", "POST"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function addImage(Request $request)
    {
        $img = new Image();
        $form =$this->createForm(ImageType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $imgFile */
            $imgFile = $form['image']->getData();
            $originalFilename =  pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newfilename = $safeFilename.'_'.uniqid().'.'.$imgFile->guessExtension();
            try{
                $imgFile->move(
                  $this->getParameter('images_directory'),
                    $newfilename
                );
            }catch (FileException $e){

            }
            $img->setImageFilename($newfilename);
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