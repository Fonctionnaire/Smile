<?php


namespace App\Controller\Home;



use App\Entity\EasterEgg;
use App\Repository\EasterEggRepository;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(QuoteRepository $quoteRepository, EasterEggRepository $easterEggRepository)
    {
        $now = new \DateTime();
        $quote = $quoteRepository->findOneQuoteByDate($now);
        $ee = $easterEggRepository->findLastEasterEgg();
        return $this->render('home/home.html.twig', [
            'quote' => $quote,
            'ee' => $ee
        ]);
    }
}