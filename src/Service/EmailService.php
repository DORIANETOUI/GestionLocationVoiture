<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Location;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendLocationCreatedEmail(Location $location): void
    {
        $client = $location->getClient();
        if ($client && $client->getEmail()) {
            $email = (new TemplatedEmail())
                ->from('touiloudoriane@gmail.com') // Votre adresse email
                ->to($client->getEmail())
                ->subject('Confirmation de location')
                ->htmlTemplate('emails/location_created.html.twig')
                ->context([
                    'location' => $location,
                    'client' => $client,
                ]);

            $this->mailer->send($email);
        }
    }
}
