<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Series;
use App\Entity\Episode;
use App\Form\SeriesType;
use App\Form\SeriesEditType;
use App\DTO\SeriesCreateFormInput;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeriesController extends AbstractController
{

    public function __construct(private SeriesRepository $seriesRepository, private EntityManagerInterface $entityManager){

    }


    #[Route('/series', name: 'app_series', methods:['GET'])]
    public function seriesList(Request $request): Response
    {

        $seriesList = $this->seriesRepository->findAll();
        $session = $request->getSession();
        // Forma simples de trabalhar com Flash Message
        // $successMessage = $session->get('success');
        // $session->remove('success');

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
            // 'successMessage' => $successMessage,
        ]);

    }

    #[Route('/series/create',  name: 'app_series_form', methods:['GET'])]
    public function addSeriesForm(): Response
    {
        // $seriesForm = $this->createFormBuilder(new Series(''))
        //         ->add('name', TextType::class, ['label' => 'Nome Série:'])
        //         ->add('save', SubmitType::class, ['label' => 'Adicionar'])
        //         ->getForm();

        $seriesForm = $this->createForm(SeriesType::class, new SeriesCreateFormInput());
        
        return $this->renderForm('series/form.html.twig', compact('seriesForm'));

    }

    #[Route('/series/create', name: 'app_add_series', methods:['POST'])]
    public function addSeries(Request $request): Response
    {
        $input = new SeriesCreateFormInput();
        $seriesForm = $this->createForm(SeriesType::class, $input)->handleRequest($request);

        if( !$seriesForm->isValid() ){
            return $this->renderForm('series/form.html.twig', compact('seriesForm'));
        }

        $series = new Series($input->seriesName);

        for( $i = 1; $i <= $input->seasonsQuantity; $i++ ){

            $season = new Season($i);

            for( $j = 1; $j <= $input->episodesPerSeason; $j++ ){

                $season->addEpisode(new Episode($j));

            }

            $series->addSeason($season);

        }

        $this->addFlash('success', "Série \"{$series->getName()}\"	adicionada c/ sucesso");
        // Forma simples de trabalhar com Flash Message
        // $request->getSession()->set('success', "Série \"{$serieName}\"	adicionada c/ sucesso");

        $this->seriesRepository->add($series, true);

        return new RedirectResponse('/series');

    }

    #[Route('/series/delete/{id}', name: 'app_delete_series', methods:['DELETE'], requirements:['id' => '[0-9]+'])]
    public function deleteSeries(int $id, Request $request, Series $series): Response
    {       
        $this->seriesRepository->removeById($id);

        $this->addFlash('danger', "Série \"{$series->getName()}\" removida c/ sucesso");
        
        // Forma simples de trabalhar com Flash Message
        // $session = $request->getSession();        
        // $session->set('success', 'Série removida c/ sucesso');

        return new RedirectResponse('/series');
    }

    #[Route('/series/edit/{series}', name: 'app_edit_series_form', methods:['GET'])]
    public function editSeriesForm(Series $series): Response
    {       
        $seriesForm = $this->createForm(SeriesEditType::class, $series);
        return $this->renderForm('series/edit.html.twig', compact('seriesForm', 'series'));
    }

    #[Route('/series/edit/{series}', name: 'app_store_series_changes', methods:['PATCH'])]
    public function editSeriesChanges(Series $series, Request $request): Response
    {  
        
        $seriesForm = $this->createForm(SeriesEditType::class, $series);
        $seriesForm->handleRequest($request);

        // Forma simples de atualizar o dado quando utilizar HTML no twig
        // $series->setName($request->request->get('name'));

        if( !$seriesForm->isValid() ){
            return $this->renderForm('series/edit.html.twig', compact('seriesForm', 'series'));
        }

        $this->addFlash('warning', "Série \"{$series->getName()}\" editada c/ sucesso");
        //  Forma simples de trabalhar com Flash Message
        // $request->getSession()->set('success', "Série \"{$series->getName()}\" editada c/ sucesso");

        $this->entityManager->flush();

        return new RedirectResponse('/series');
    }
}
