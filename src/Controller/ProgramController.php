<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        dump($programs);
        //  return new Response('<html><body>Wild Series Index</body></html>');
        return $this->render('program/index.html.twig', ['website' => 'Wild Series', 'programs' => $programs]);
    }

    #[Route('/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show($id): Response
    {
        return $this->render('program/show.html.twig', ['id' => $id]);
    }
}
