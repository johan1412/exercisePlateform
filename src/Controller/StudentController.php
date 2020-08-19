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
        $coursInscrit = $this->getUser()->getCours();
        $uid = $this->getUser()->getId();
        $coursNonInscrit = $repo->findCoursNotRegistered($uid);

        return $this->render('student/index.html.twig', [
            'coursInscrit' => $coursInscrit,
            'coursNonInscrit' => $coursNonInscrit,
        ]);
    }
}
