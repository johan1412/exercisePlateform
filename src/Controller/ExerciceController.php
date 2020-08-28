<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Exercice;
use App\Entity\Stats;
use App\Form\ExerciceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\Cache\CacheInterface;

class ExerciceController extends AbstractController
{
    /**
     * @Route("/teacher/exercice/new", name="new_exercice")
     */
    public function newExercice(Request $request, SessionInterface $session)
    {   
        $cours = $session->get('cours');
        if($cours == null) {
            return $this->redirectToRoute('/teacher/homepage');
        }
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $nbInstructions = $request->get('compteur');
            $descriptions = [];
            $j = 0;
            for($i=1; $i <= $nbInstructions; $i++) {
                if($request->get('instruction'.$i)) {
                    $descriptions[$j] = $request->get('instruction'.$i);
                    $j++;
                }
            }
            $cours2 = $this->getDoctrine()
                ->getRepository(Cours::class)
                ->find($cours->getId());
            $cours->addExercice($exercice);
            $exercice->setCours($cours2);
            $exercice->setInstructions($descriptions);
            $em = $this->getDoctrine()->getManager();
            $em->persist($exercice);
            $em->persist($cours2);
            $em->flush();
            $this->addFlash('success', 'L\'exercice a été ajouté avec succès');
            return $this->redirectToRoute('show_cours', [
                'id' => $cours2->getId(),
            ]);
        }

        return $this->render('exercice/addExercice.html.twig', [
            'form' => $form->createView(),
            'cours' => $cours,
        ]);
    }


    /**
     * @Route("/teacher/exercice/resultats/{id}", name="res_exercice")
     */
    public function resExercice(Exercice $exercice)
    {

        return $this->render('exercice/res.html.twig', [
            'exercice' => $exercice,
        ]);
    }


    /**
     * @Route("/student/exercice/show/{id}", name="show_exercice")
     */
    public function showExercice(Exercice $exercice)
    {
        $instructions = $exercice->getInstructions();
        shuffle($instructions);
        return $this->render('exercice/show.html.twig', [
            'exercice' => $exercice,
            'instructions' => $instructions,
        ]);
    }


    /**
     * @Route("/student/exercice/{id}/verify", name="verify_exercice", methods={"POST"})
     */
    public function verifyResponse(Request $request, Exercice $exercice)
    {
        
            $solution = $exercice->getInstructions();
            $res = [];
            for($i = 1; $i <= count($solution); $i++) {
                array_push($res, $request->request->get($i));
            }
            $stats = $this->getDoctrine()->getRepository(Stats::class)
                    ->findOneBy([
                        'student' => $this->getUser(),
                        'exercice' => $exercice,
                    ]);
            if(!$stats) {
                $stats = new Stats();
                $stats->setStudent($this->getUser());
                $stats->setExercice($exercice);
                $stats->setTries(1);
                $stats->setSuccess(false);
            } else {
                $stats->setTries($stats->getTries() + 1);
            }

            if($res == $solution) {
                $stats->setSuccess(true);
                $response = new JsonResponse([
                    'valid' => true
                ]);
            } else {
                $response = new JsonResponse([
                    'valid' => false
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($stats);
            $em->flush();

            return $response;

        
    }
}
