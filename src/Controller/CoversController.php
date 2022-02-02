<?php

namespace App\Controller;

use App\Entity\Covers;
use App\Form\CoversType;
use App\Repository\CoversRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/covers")
 */
class CoversController extends AbstractController
{
    /**
     * @Route("/", name="covers_index", methods={"GET"})
     */
    public function index(CoversRepository $coversRepository): Response
    {
        return $this->render('covers/index.html.twig', [
            'covers' => $coversRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="covers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cover = new Covers();
        $form = $this->createForm(CoversType::class, $cover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cover);
            $entityManager->flush();

            return $this->redirectToRoute('covers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('covers/new.html.twig', [
            'cover' => $cover,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="covers_show", methods={"GET"})
     */
    public function show(Covers $cover): Response
    {
        return $this->render('covers/show.html.twig', [
            'cover' => $cover,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="covers_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Covers $cover, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoversType::class, $cover);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('covers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('covers/edit.html.twig', [
            'cover' => $cover,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="covers_delete", methods={"POST"})
     */
    public function delete(Request $request, Covers $cover, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cover->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cover);
            $entityManager->flush();
        }

        return $this->redirectToRoute('covers_index', [], Response::HTTP_SEE_OTHER);
    }
}
