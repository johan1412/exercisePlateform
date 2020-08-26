<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student/homepage", name="student_homepage")
     */
    public function index(CoursRepository $repo)
    {
        $user = $this->getUser();
        $coursInscrit = $this->getUser()->getCours();
        $allcours = $repo->findAll();
        $coursNonInscrit = [];
        foreach($allcours as $cours) {
            if(!$cours->getStudents()->contains($user)) {
                array_push($coursNonInscrit, $cours);
            }
        }

        return $this->render('student/index.html.twig', [
            'coursInscrit' => $coursInscrit,
            'coursNonInscrit' => $coursNonInscrit,
        ]);
    }
}
