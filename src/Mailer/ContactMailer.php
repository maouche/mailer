<?php

namespace App\Mailer;

use App\Entity\Contact;
use Twig\Environment;


use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ContactMailer {
	
	/**
	 * @var MailerInterface
	 */
	private $mailer;

	/**
	 * @var Environment
	 */
	private $renderer;

	public function __construct(MailerInterface $mailer, Environment $renderer) {
		$this->mailer = $mailer;
		$this->renderer = $renderer;
	}

	public function send(Contact $contact) {
        $email = (new Email())
            ->from('noreply@yacinem.com')
            ->to('hello@yacinem.com')
            ->replyTo($contact->getEmail())
            ->subject($contact->getSubject())
            ->html($this->renderer->render('emails/contact.html.twig', [
				'contact' => $contact
			]));

        $this->mailer->send($email);
	}
}