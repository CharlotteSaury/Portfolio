<?php

namespace App\Manager;

use App\Entity\Contact;
use App\Helper\MailSenderHelper;

class ContactManager
{
    private $mailSenderHelper;

    public function __construct(MailSenderHelper $mailSenderHelper) {
        $this->mailSenderHelper = $mailSenderHelper;
    }

    public function handleContactForm(Contact $contact)
    {
        $this->mailSenderHelper->sendMail($contact);
        $this->mailSenderHelper->sendNotification($contact);
    }
}