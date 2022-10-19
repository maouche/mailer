<?php

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Mailer\ContactMailer;
use App\Entity\Contact;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    #[Route('/contact')]
    public function contactAction( ContactMailer $mailer, Request $request ): JsonResponse {

        $data = json_decode($request->getContent(), true);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->submit($data, true);

        if ( $form->isSubmitted() && $form->isValid() ) {
            $mailer->send($contact);
            $response = new JsonResponse([
                "message" => 'Your email has been sent.'
            ], 200);
        } else {
            $response = new JsonResponse([
                "message" => 'Your email is not valid, please verify your information.'
            ], 301);
        }

        return $response;
    }
}