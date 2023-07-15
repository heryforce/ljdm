<?php

namespace App\Controller;

use App\Repository\PlanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RootController extends AbstractController
{
    #[Route('/', name: 'root')]
    public function index(): Response
    {
        return $this->redirectToRoute('main_index');
    }
}
