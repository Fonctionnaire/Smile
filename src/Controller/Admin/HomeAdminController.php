<?php


namespace App\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeAdminController extends AbstractController
{

    /**
     * @Route("/a-s", name="admin_home", methods={"GET"})
     * @IsGranted({"ROLE_ADMIN"})
     */
    public function adminHome()
    {


        return $this->render('admin/HomeAdmin.html.twig');
    }
}