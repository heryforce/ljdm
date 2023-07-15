<?php

namespace App\Controller;

use App\Repository\PlanteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/main')]
class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(PlanteRepository $planteRepository): Response
    {
        $plantes = $planteRepository->findAll();
        return $this->render('main/index.html.twig', [
            'plantes' => $plantes
        ]);
    }
}
