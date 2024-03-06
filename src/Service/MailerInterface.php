<?php
// src/Service/MailService.php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
private $mailer;

public function __construct(MailerInterface $mailer)
{
$this->mailer = $mailer;
}

public function sendEmail(string $to, string $subject, string $body): void
{
$email = (new Email())
->from('your_email@example.com') // Replace with your email
->to($to)
->subject($subject)
->html($body);

$this->mailer->send($email);
}
}
?>
