<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Plante;
use App\Entity\User;
use App\Form\PlanteType;
use App\Repository\CarouselAccueilRepository;
use App\Repository\PlanteRepository;
use App\Repository\UserPlanteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PlanteRepository $planteRepository, CarouselAccueilRepository $carouselAccueilRepository): Response
    {
        $carousel = $carouselAccueilRepository->findAll();
        $plantes = $planteRepository->findBy(['temporaire' => false]);
        return $this->render('main/index.html.twig', [
            'plantes' => $plantes,
            'carousel' => $carousel,
        ]);
    }

    #[Route('/proposition/plante', name: 'proposition_plante')]
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
                return $this->redirectToRoute('proposition_plante');
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

    #[Route('/chez+melo', name: 'chez_melo')]
    public function chezMelo(UserPlanteRepository $userPlanteRepository, UserRepository $userRepository)
    {
        $userPlantes = $userPlanteRepository->findBy(['user' => $userRepository->findOneBy(['email' => 'admin@admin.com'])]);
        $tabPlantes = [];
        foreach ($userPlantes as $userPlante) {
            $tabPlantes[] = [
                'nomFr' => $userPlante->getPlante()->getNom(),
                'nomLatin' => $userPlante->getPlante()->getNomLatin(),
                'photo' => $userPlante->getPlante()->getPhotos()[0]->getFichier(),
            ];
        }

        return $this->render('main/chez_melo.html.twig', [
            'tabPlantes' => $tabPlantes,
        ]);
    }
}
