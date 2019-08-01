<?php


namespace App\Controller\Legal;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{

    /**
     * @Route("/{_locale}/mentions-legales", name="mentions_legales", methods={"GET"}, defaults={"_locale"="fr"}, requirements={"_locale"="%app.locales%"})
     */
    public function legal(Request $request)
    {
        $locale = $request->getLocale();
        return $this->render('legal/mentions.html.twig', [
            'locale' => $locale
        ]);
    }
}