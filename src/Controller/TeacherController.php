<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher/homepage", name="teacher_homepage")
     */
    public function index()
    {
        $cours = $this->getUser()->getCours();
        return $this->render('teacher/index.html.twig', [
            'cours' => $cours,
        ]);
    }

}
