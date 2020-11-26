<?php

namespace App\Helper;

use Exception;
use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;

class MailSenderHelper
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle contact form mail sending.
     *
     * @return void
     */
    public function sendMail(Contact $contact)
    {
        $email = (new Email())
            ->from(new Address($contact->getEmail(), $contact->getName()))
            ->to('saury.charlotte@wanadoo.fr')
            ->subject($contact->getSubject())
            ->html('<p>'.$contact->getContent().'</p>');

        $this->mailer->send($email);
    }

    /**
     * Handle contact form notification to visitor.
     *
     * @return void
     */
    public function sendNotification(Contact $contact)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('saury.charlotte@wanadoo.fr', 'Charlotte SAURY'))
            ->to($contact->getEmail())
            ->subject('Merci pour votre contact !')
            ->htmlTemplate('email/contact_notification.html.twig')
            ->context([
                'contact' => $contact
            ]);

        $this->mailer->send($email);
    }
}
