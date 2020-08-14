<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/teacher/cours/new", name="new_cours")
     */
    public function newCours(Request $request)
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $cours->setTeacher($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();
            $this->addFlash('success', 'Le cours a été ajouté avec succès');
            return $this->redirectToRoute('teacher_homepage');
        }

        return $this->render('cours/addCours.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("teacher/cours/show/{id}", name="show_cours")
     */
    public function show(Cours $cours, SessionInterface $session)
    {
        $exercices = $cours->getExercices();
        $session->set('cours', $cours);
        return $this->render('cours/show.html.twig', [
            'exercices' => $exercices,
            'cours' => $cours,
        ]);
    }
}
