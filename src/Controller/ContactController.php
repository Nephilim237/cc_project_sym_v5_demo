<?php

namespace App\Controller;

use App\Form\ContactSiteFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{


    /**
     * @Route("/contact", name="contact")
     * @param Request         $request
     *
     * @param MailerInterface $mailer
     *
     * @return RedirectResponse|Response
     * @throws TransportExceptionInterface
     */
    public function contactUs(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactSiteFormType::class);
        $contact = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $senderEmail = $contact->get('email')->getData();
            $email = (new TemplatedEmail())
                ->from($senderEmail)
                ->to(new Address('codingcity@cc.com', 'Coding City'))
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('emails/contact_site.html.twig')
                ->context([
                    'senderName'  => $contact->get('name')->getData(),
                    'sender' => $senderEmail,
                    'message' => $contact->get('message')->getData(),
                ])
            ;
            $mailer->send($email);
            $this->addFlash('success', "Méssage envoyé avec succès.");
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/contact.html.twig', [
            'contactForm'   =>      $form->createView(),
        ]);
    }
}
