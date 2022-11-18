<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Episode;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
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

        //  return new Response('<html><body>Wild Series Index</body></html>');
        return $this->render('program/index.html.twig', ['website' => 'Wild Series', 'programs' => $programs]);
    }

    #[Route('/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show(int $id, Program $prog, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // avec méthode magique __call :
        // $programs = $programRepository->findOneById($id);
        // ou ++ same as $program = $programRepository->find($id);

        $seasons = $prog->getSeasons();
        dump($seasons);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route('/{programId}/season/{seasonId}', methods: ['GET'], name: 'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository)
    {
        $program = $programRepository->findOneById(['programId' => $programId]);
        $season = $seasonRepository->findOneById(['seasonId' => $seasonId]);
        $episodes = $episodeRepository->findBy(['season' => $season], ['number' => 'ASC']);

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }
}
