<?php


namespace App\Service;


use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ContactMail
{


    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var EngineInterface
     */
    private $engine;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $engine)
    {


        $this->mailer = $mailer;
        $this->engine = $engine;
    }

    public function sendContactMail(Contact $contact)
    {
        $message = (new \Swift_Message($contact->getSubject()))
            ->setFrom('no-reply@dailycomforting.com')
            ->setTo('contact@gailycomforting.com')
            ->setBody(
                $this->engine->render(
                    'email/contactMail.html.twig', [
                        'contact' => $contact
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);

    }
}