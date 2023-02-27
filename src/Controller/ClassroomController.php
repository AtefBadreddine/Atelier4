<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Classroom;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('//classroom/afficher', name: 'affichage')]
    public function afficherListe(ManagerRegistry $doctrine)
    {
        $repository=$doctrine->getRepository(Classroom::class);

        $list=$repository->findAll();

        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }
    #[Route('//classroom/ajouter/{name}', name: 'ajout')]
    public function AjouterClassroom(ManagerRegistry $doctrine, $name)
    {
        $classroom=new Classroom();
        $classroom->setName($name);
        $em=$doctrine->getManager();
        $em->persist($classroom);
        $em->flush();


        $repository=$doctrine->getRepository(Classroom::class);
        $list=$repository->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }

    #[Route('//classroom/modifier/{id}', name: 'modification')]
    public function ModifierClassroom(ManagerRegistry $doctrine , $id): Response
    {
        $em=$doctrine->getManager();
        $repository=$doctrine->getRepository(Classroom::class);
        $classroom=$repository->find($id);
        $classroom->setName("EDITED");

        $em->flush();
        $repository=$doctrine->getRepository(Classroom::class);
        $list=$repository->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }
    #[Route('//classroom/supprimer/{id}', name: 'suppression')]
    public function SupprimerClassroom(ManagerRegistry $doctrine , $id)
    {
        $em=$doctrine->getManager();
        $repository=$doctrine->getRepository(Classroom::class);
        $classroom=$repository->find($id);
        $em->remove($classroom);

        $em->flush();
        $repository=$doctrine->getRepository(Classroom::class);
        $list=$repository->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }



}
