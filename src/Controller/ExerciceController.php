<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ExerciceController extends AbstractController
{
    /**
     * @Route("/teacher/exercice/new", name="new_exercice")
     */
    public function newExercice(Request $request, SessionInterface $session)
    {
        $cours = $session->get('cours');
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $exercice->setCours($cours);
            $em = $this->getDoctrine()->getManager();
            $em->persist($exercice);
            $em->flush();
            $this->addFlash('success', 'L\'exercice a été ajouté avec succès');
            return $this->redirectToRoute('/teacher/cours/shows/'.$cours->getId());
        }

        return $this->render('exercice/addExercice.html.twig', [
            'form' => $form->createView(),
            'cours' => $cours,
        ]);
    }
}
