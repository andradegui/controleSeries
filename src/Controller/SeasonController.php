<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Series;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SeasonController extends AbstractController
{
    public function __construct(private CacheInterface $cache){
        
    }

    #[Route('/series/{series}/seasons', name: 'app_season')]
    public function index(Series $series): Response
    {
        $seasons = $this->cache->get(
            "series_{$series->getId()}_seasons",
            function (ItemInterface $item) use ($series) {
                $item->expiresAfter(new \DateInterval('PT10S'));

                /** @var PersistentCollection $seasons */
                $seasons = $series->getSeasons();
                $seasons->initialize();

                return $seasons;
            }
        );

        // dd($seasons->count());

        // $seasons = $series->getSeasons();

        return $this->render('season/index.html.twig', [
            'seasons' => $seasons,
            'series' => $series,
        ]);
    }
}
