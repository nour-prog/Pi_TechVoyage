<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboard extends AbstractController
{
    #[Route('/backoffice/dashboard', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('backoffice/dashboard/index.html.twig');
    }
}
