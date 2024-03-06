<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Series;

class SeasonController extends AbstractController
{
    #[Route('/series/{series}/seasons', name: 'app_season')]
    public function index(Series $series): Response
    {
        $seasons = $series->getSeasons();

        return $this->render('season/index.html.twig', [
            'seasons' => $seasons,
            'series' => $series,
        ]);
    }
}
