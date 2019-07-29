<?php


namespace App\Controller\Api;


use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{

    /**
     * @Route("/getmessage", name="get_message", methods={"GET"})
     */
    public function getMessage(SerializerInterface $serializer)
    {
        $quote = new Quote();
        $quote->setAddDate(new \DateTime());
        $quote->setAuthor('gege');
        $quote->setFrContent('fr');
        $quote->setEnContent('en');
        $quote->setReleaseDate(new \DateTime());

        $data = $serializer->serialize($quote, 'json');
        $rep = new Response($data);
        $rep->headers->set('Content-Type', 'application/json');

        return $rep;
    }

    /**
     * @Route("/getmessages", name="get_message", methods={"GET"})
     */
    public function getMessages(SerializerInterface $serializer, QuoteRepository $quote)
    {
        $allQuotes = $quote->findAll();

        $data = $serializer->serialize($allQuotes, 'json');
        $rep = new Response($data);
        $rep->headers->set('Content-Type', 'application/json');

        return $rep;
    }

    /**
     * @Route("/getmessage/{id}", name="get_message", methods={"GET"})
     */
    public function getMessageById(SerializerInterface $serializer, QuoteRepository $quote, $id)
    {
        $result = $quote->findOneById($id);

        $data = $serializer->serialize($result, 'json');
        $rep = new Response($data);
        $rep->headers->set('Content-Type', 'application/json');

        return $rep;
    }
}