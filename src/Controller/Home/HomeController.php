<?php


namespace App\Controller\Home;



use App\Entity\EasterEgg;
use App\Repository\EasterEggRepository;
use App\Repository\ImageRepository;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/{_locale}", name="home", methods={"GET"}, defaults={"_locale"="fr"}, requirements={"_locale"="%app.locales%"})
     */
    public function home(QuoteRepository $quoteRepository, EasterEggRepository $easterEggRepository, ImageRepository $imageRepository, Request $request)
    {
        $locale = $request->getLocale();
        $now = new \DateTime();
        $quote = $quoteRepository->findOneQuoteByDate($now);

        if($quote === null)
        {
            $quote = $quoteRepository->findLastQuote();
        }
        $ee = $easterEggRepository->findLastEasterEgg();
        $fbImage = $imageRepository->findOneImg();
        return $this->render('home/home.html.twig', [
            'locale' => $locale,
            'quote' => $quote,
            'ee' => $ee,
            'fbImage' => $fbImage
        ]);
    }
}