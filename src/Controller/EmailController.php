<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EmailService;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(EmailService $emailService): Response
    {
        $subject = "Mail de test !";
        $body = "Ici le body, je suis toujours un test ! Et oui encore !!!";
        $content = $this->render('email/index.html.twig', [
            'subject' => $subject,
            'body' => $body,
        ]);
        $emailService->sendEmail('salmon.laura@laposte.net',$subject, $content->getContent());
        return new Response ('Le mail a bien été envoyé');
    }
}
