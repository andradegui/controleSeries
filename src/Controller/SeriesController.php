<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeriesRepository;
use App\Entity\Series;

class SeriesController extends AbstractController
{

    public function __construct(private SeriesRepository $seriesRepository){

    }


    #[Route('/series', name: 'app_series', methods:['GET'])]
    public function seriesList(): Response
    {

        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);

    }

    #[Route('/series/create', methods:['GET'])]
    public function addSeriesForm(): Response
    {
        
        return $this->render('series/form.html.twig');

    }

    #[Route('/series/create', methods:['POST'])]
    public function addSeries(Request $request): Response
    {

        $serieName = $request->request->get('name');
        $serie = new Series($serieName);

        $this->seriesRepository->add($serie, true);

        return new RedirectResponse('/series');

    }
}
