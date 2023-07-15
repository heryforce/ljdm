<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Plante;
use App\Entity\User;
use App\Form\PlanteType;
use App\Repository\PhotoRepository;
use App\Repository\PlanteRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard_index')]
    public function index(PlanteRepository $planteRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'plantes' => $planteRepository->findAll(),
        ]);
    }

    #[Route('/add/plante/', name: 'dashboard_add_plante')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface, #[CurrentUser()] ?User $user)
    {
        $session = $request->getSession();
        $plante = new Plante();
        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($session->get('files', []) as $fichier) {
                $photo = new Photo();
                $photo->setFichier($fichier)
                    ->setPlante($plante);
                $entityManagerInterface->persist($photo);
            }
            $plante->setUser($user);
            $entityManagerInterface->persist($plante);
            $entityManagerInterface->flush();
            $this->addFlash('success', 'Ta nouvelle plante est prête !');
            $session->clear();

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render('dashboard/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/plante/{id}', name: 'dashboard_edit_plante')]
    public function edit(?Plante $plante, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if (!$plante)
            return $this->redirectToRoute('dashboard_index');

        dump($request->getSession()->get('files', []));
        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $request->getSession();
            foreach ($session->get('files', []) as $fichier) {
                $photo = new Photo();
                $photo->setFichier($fichier)
                    ->setPlante($plante);
                $entityManagerInterface->persist($photo);
            }
            $entityManagerInterface->persist($plante);
            $entityManagerInterface->flush();
            $this->addFlash('success', 'Tes modifications ont bien été prises en compte !');
            $session->clear();

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render('dashboard/edit.html.twig', [
            'form' => $form,
            'plante' => $plante,
        ]);
    }

    #[Route('/remove/plante/{id}', name: 'dashboard_remove_plante')]
    public function remove(?Plante $plante, EntityManagerInterface $entityManagerInterface)
    {
        if (!$plante)
            return $this->redirectToRoute('dashboard_index');

        $entityManagerInterface->remove($plante);
        $entityManagerInterface->flush();
        $this->addFlash('success', 'La plante a bien été supprimée !');

        return $this->redirectToRoute('dashboard_index');
    }

    #[Route('/remove/photo/{planteId}/{photoId}/', name: 'dashboard_remove_photo')]
    public function photoRemove(#[CurrentUser()] ?User $user, PhotoRepository $photoRepository, PlanteRepository $planteRepository, EntityManagerInterface $entityManagerInterface, $photoId, $planteId, $photosDossier, Request $request)
    {
        $photo = $photoRepository->find($photoId);
        $plante = $planteRepository->find($planteId);
        if (!$user || !$photo || !$plante || ($photo && $plante && $photo->getPlante() !== $plante)) {
            return $this->render('error/404.html.twig');
        }

        $fs = new Filesystem();
        $session = $request->getSession();
        if ($fs->exists($photosDossier . $photo->getFichier())) {
            $tabPhotos = $session->get('files', []);
            foreach ($tabPhotos as $k => $fichier) {
                if ($fichier === $photo->getFichier()) {
                    unset($tabPhotos[$k]);
                }
            }
            $session->set('files', $tabPhotos);
            $fs->remove($photosDossier . $photo->getFichier());
            $entityManagerInterface->remove($photoRepository->find($photoId));
            $entityManagerInterface->flush();
            $this->addFlash('success', 'La photo a bien été supprimée !');
        }
        return $this->redirectToRoute('dashboard_edit_plante', [
            'id' => $planteId,
        ]);
    }
}
