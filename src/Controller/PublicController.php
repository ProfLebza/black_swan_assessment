<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Utils\FormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PublicController extends AbstractController
{



    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {

        $response = [
            'page_title' => 'Programming Assessment by Lebogang Ratsoana',
        ];
        return $this->render('public/index.html.twig', $response);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param Swift_Mailer $swiftMailer
     * @return Response
     * @Route("/contact", name="contact_page")
     */
    public function contact(Request $request, EntityManagerInterface $entityManager, Swift_Mailer $swiftMailer): Response
    {
        $messageId = 0;

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact, [
            'action' => $this->generateUrl('contact_page'),
            'attr' => ['id' => 'contact-form']
        ]);

        $form->handleRequest($request);

        $response = FormHandler::saveForm($form, $messageId, $contact, $entityManager, 'Contact');

        if ($response['submitted'] && $response['success']) {
            $this->sendNotificationEmail($contact, $swiftMailer);
        }
        $response['form'] = $form->createView();
        return $this->render('public/contact.html.twig', $response);
    }

    /**
     * @param Contact $contact
     * @param Swift_Mailer $swiftMailer
     */
    public function sendNotificationEmail(Contact $contact, Swift_Mailer $swiftMailer) {

        $sendToEmailAddress = $this->getParameter('system_admin_email') ?? 'lebogang.ratsoana@yahoo.com';
        $adminName = $this->getParameter('system_mane') ?? 'Black Swan Assessment';

        $parameters = [
            'contact' => $contact,
            'admin_name' => $adminName,
            'subject' => 'Contact Form Submitted',
        ];

        $this->sendEmail($swiftMailer, $sendToEmailAddress, $parameters, true);
        $this->sendEmail($swiftMailer, $contact->getEmail(), $parameters, false);

    }

    /**
     * @param Swift_Mailer $swiftMailer
     * @param string $sendToEmailAddress
     * @param array $parameters
     * @param bool $sendToAdmin
     */
    public function sendEmail(Swift_Mailer $swiftMailer, string $sendToEmailAddress, array $parameters, bool  $sendToAdmin = false) {

        $parameters['is_contact_us_admin'] = $sendToAdmin;

        $message = (new \Swift_Message($parameters['subject']))
            ->setFrom($this->getParameter('contact_mail_address'), $parameters['subject'])
            ->setTo($sendToEmailAddress)
            ->setBody(
                $this->renderView(
                    'email/contact-us-email.html.twig', $parameters
                ),
                'text/html'
            );

        $swiftMailer->send($message);
    }

}