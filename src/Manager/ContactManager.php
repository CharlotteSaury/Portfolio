<?php

namespace App\Manager;

use App\Entity\Contact;
use App\Helper\MailSenderHelper;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    private $mailSenderHelper;

    private $entityManager;

    public function __construct(MailSenderHelper $mailSenderHelper, EntityManagerInterface $entityManager) {
        $this->mailSenderHelper = $mailSenderHelper;
        $this->entityManager = $entityManager;
    }

    public function handleContactForm(Contact $contact)
    {
        $this->mailSenderHelper->sendMail($contact);
        $this->mailSenderHelper->sendNotification($contact);
    }
}