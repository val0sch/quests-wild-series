<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Episode;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $programs = $programRepository->findAll();

        //  return new Response('<html><body>Wild Series Index</body></html>');
        return $this->render('program/index.html.twig', ['website' => 'Wild Series', 'programs' => $programs]);
    }


    // #[Route('/new', name: 'new')]
    // public function new(Request $request, ProgramRepository $programRepository): Response
    // {
    //     $program = new Program();

    //     // Create the form, linked with $category
    //     $form = $this->createForm(ProgramType::class, $program);

    //     $form->handleRequest($request);

    //     // Was the form submitted ?
    //     if ($form->isSubmitted()) {
    //         $programRepository->save($program, true);

    //         // Redirect to categories list
    //         return $this->redirectToRoute('program_index');
    //     }

    //     // Render the form (best practice)
    //     return $this->renderForm('program/new.html.twig', [
    //         'form' => $form,
    //     ]);

    //     // Alternative
    //     // return $this->render('category/new.html.twig', [
    //     //   'form' => $form->createView(),
    //     // ]);
    // }

    #[Route('/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show(Program $program): Response
    {
        //$program = $programRepository->findOneBy(['id' => $id]);
        // avec méthode magique __call :
        // $programs = $programRepository->findOneById($id);
        // ou ++ same as $program = $programRepository->find($id);

        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program['id'] . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route('/{program}/season/{season}', methods: ['GET'], name: 'season_show')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository)
    {
        // $program = $programRepository->findOneById(['programId' => $programId]);
        // $season = $seasonRepository->findOneById(['seasonId' => $seasonId]);
        $episodes = $episodeRepository->findBy(['season' => $season]);
        // $episodes = $season->getEpisodes();

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }

    #[Route('/{program}/season/{season}/episode/{episode}', methods: ['GET'], name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        // $program = $programRepository->findOneById(['programId' => $programId]);
        // $season = $seasonRepository->findOneById(['seasonId' => $seasonId]);
        //   $episodes = $episodeRepository->findBy(['season' => $season]);
        // $episodes = $season->getEpisodes();

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}
