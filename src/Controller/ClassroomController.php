<?php

namespace App\Controller;
use App\Form\ClassroomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Classroom;
use App\Repository\StudentRepository;
class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    
  
        #[Route('/fetchC', name: 'fetchC')]
      
        public function fetchC(ClassroomRepository $repo): Response
        {
            $resul= $repo->findAll();
            return $this->render('classroom/test.html.twig', [
                'Response' => $resul,
            ]);
        }
    
        #[Route('/addC', name: 'addC')]
        public function addC(Request $request, ManagerRegistry $mr): Response
        {
            
            $clas = new classroom();
            $form = $this->createForm(ClassroomType::class, $clas);
    
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
            $em=$mr->getManager();
            $em->persist($clas);
            $em->flush();
      
          
         return $this->redirectToRoute('fetch'); 
        }
        return $this->render('classroom/form.html.twig', [
            'form' => $form->createView(),
        ]);
        }
  
        
      
        public function __toString()
      {
        return $this->name; 
    }
        }
    

