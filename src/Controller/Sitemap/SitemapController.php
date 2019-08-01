<?php
/**
 * Created by PhpStorm.
 * User: thiba
 * Date: 19/08/2018
 * Time: 17:26
 */

namespace App\Controller\Sitemap;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{

    /**
     * @Route("/sitemap", name="sitemap")
     */
    public function sitemap()
    {
        return $this->render('sitemap/sitemap.xml');
    }
}