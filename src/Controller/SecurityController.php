<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig', [
            'error' => $error,
        ]);
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/inscription/{role}", name="inscription", defaults={"role":"none"})
     */
    public function inscription(Request $request, $role, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $role == "teacher" ? new Teacher() : new Student();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('teacher_homepage');
        }

        $this->addFlash('success', 'Vous avez été ajouté avec succès');
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function admin_index()
    {
        return dd("coucou admin user...");
    }

}
