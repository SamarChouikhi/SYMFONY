<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Student;
use App\Entity\Classroom;

use App\Form\StudentType;





//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;



class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo): Response{
    $result=$repo->findAll();
    return $this->render('Student/test.html.twig', [
        'Response' => $result,
    ]);
    
} 
#[Route('/add', name: 'add')]
    public function add(Request $request, ManagerRegistry $mr): Response
    {
        
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $em=$mr->getManager();
        $em->persist($student);
        $em->flush();
  
      
     return $this->redirectToRoute('fetch');
    }
    return $this->render('student/form.html.twig', [
        'form' => $form->createView(),
    ]);
    }

#[Route('/rm/{id}', name: 'rm')]
public function remove(StudentRepository $repo, $id, ManagerRegistry $mr):Response
{
    $student = $repo->find($id);
    $em = $mr->getManager();
    $em->remove($student);
    $em->flush();
    return $this->redirectToRoute('fetch');
}
#[Route('/student/edit/{id}', name: 'edit_student', methods: ['GET', 'POST'])]
public function edit(Request $request, StudentRepository $repo, ManagerRegistry $mr, int $id): Response
{
    $student = $repo->find($id);

    if (!$student) {
        // Gérez le cas où l'étudiant n'est pas trouvé, par exemple, redirigez vers une page d'erreur
        return new Response('Étudiant non trouvé');
    }

    $form = $this->createForm(StudentType::class, $student);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $mr->getManager();
        $em->flush();

        return $this->redirectToRoute('fetch');
    }

    return $this->render('student/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}
} 