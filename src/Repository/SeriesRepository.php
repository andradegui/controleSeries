<?php

namespace App\Repository;

use App\Entity\Season;
use App\Entity\Series;
use App\Entity\Episode;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use App\DTO\SeriesCreateFormInput;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Series>
 *
 * @method Series|null find($id, $lockMode = null, $lockVersion = null)
 * @method Series|null findOneBy(array $criteria, array $orderBy = null)
 * @method Series[]    findAll()
 * @method Series[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeriesRepository extends ServiceEntityRepository
{
    public function __construct(
            ManagerRegistry $registry,
            private SeasonRepository $seasonRepository,
            private EpisodeRepository $episodeRepository,
            private LoggerInterface $logger
        )
    {
        parent::__construct($registry, Series::class);
    }

    public function add(SeriesCreateFormInput $input): Series 
    {

        // $this->getEntityManager()->persist($entity);

        // if($flush){
        //     $this->getEntityManager()->flush();
        // }

        $entityManager = $this->getEntityManager();

        $series = new Series($input->seriesName, $input->coverImage);
        $entityManager->persist($series);
        $entityManager->flush();

        try {
            $this->seasonRepository->addSeasonsQuantity($input->seasonsQuantity, $series->getId());
            $seasons = $this->seasonRepository->findBy(['series' => $series]);
            $this->episodeRepository->addEpisodesPerSeason($input->episodesPerSeason, $seasons);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $this->remove($series, true);
        }

        return $series;

    }

    public function remove(Series $entity, bool $flush = false): void
    {

        $this->getEntityManager()->remove($entity);

        if($flush){
            $this->getEntityManager()->flush();
        }

    }

    public function removeById(int $id): void
    {
        $series = $this->getEntityManager()->find(Series::class, $id);
        $this->remove($series, true);
    }



//    /**
//     * @return Series[] Returns an array of Series objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Series
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
