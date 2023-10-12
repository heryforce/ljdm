<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Plante;
use App\Entity\User;
use App\Form\PlanteType;
use App\Repository\PlanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(PlanteRepository $planteRepository): Response
    {
        $plantes = $planteRepository->findAll();
        return $this->render('main/index.html.twig', [
            'plantes' => $plantes
        ]);
    }

    #[Route('/proposition/plante', name: 'main_proposition_plante')]
    public function propositionPlante(Request $request, EntityManagerInterface $entityManagerInterface, #[CurrentUser()] ?User $user)
    {
        $session = $request->getSession();
        $plante = new Plante();
        $form = $this->createForm(PlanteType::class, $plante);
        $flag = 0;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($session->get('files', []) as $fichier) {
                $flag++;
                $photo = new Photo();
                $photo->setFichier($fichier)
                    ->setPlante($plante);
                $entityManagerInterface->persist($photo);
            }
            if (!$plante->getNom() && $flag == 0) {
                $this->addFlash('danger', 'Il faut au moins indiquer un nom ou envoyer une photo !');
                return $this->redirectToRoute('main_proposition_plante');
            }
            $plante->setUser($user)
                ->setTemporaire(true);
            $entityManagerInterface->persist($plante);
            $entityManagerInterface->flush();
            $this->addFlash('success', 'Melody a été notifiée de ta proposition !');
            $session->clear();
            return $this->redirectToRoute('main');
        }
        return $this->render('main/proposition_plante.html.twig', [
            'form' => $form,
        ]);
    }
}
