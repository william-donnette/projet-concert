<?php

namespace App\Controller;

use App\Entity\Scene;
use App\Form\SceneType;
use App\Repository\SceneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/scene')]
class SceneController extends AbstractController
{
    #[Route('/', name: 'scene_index', methods: ['GET'])]
    public function index(SceneRepository $sceneRepository): Response
    {
        return $this->render('scene/index.html.twig', [
            'scenes' => $sceneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'scene_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scene = new Scene();
        $form = $this->createForm(SceneType::class, $scene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scene);
            $entityManager->flush();

            return $this->redirectToRoute('scene_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scene/new.html.twig', [
            'scene' => $scene,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'scene_show', methods: ['GET'])]
    public function show(Scene $scene): Response
    {
        return $this->render('scene/show.html.twig', [
            'scene' => $scene,
        ]);
    }

    #[Route('/{id}/edit', name: 'scene_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scene $scene, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SceneType::class, $scene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('scene_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scene/edit.html.twig', [
            'scene' => $scene,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'scene_delete', methods: ['POST'])]
    public function delete(Request $request, Scene $scene, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scene->getId(), $request->request->get('_token'))) {
            $entityManager->remove($scene);
            $entityManager->flush();
        }

        return $this->redirectToRoute('scene_index', [], Response::HTTP_SEE_OTHER);
    }
}
