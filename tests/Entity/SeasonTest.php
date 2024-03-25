<?php

namespace App\Tests\Entity;

use App\Entity\Season;
use App\Entity\Episode;
use PHPUnit\Framework\TestCase;

class SeasonTest extends TestCase
{
    public function testGetWatchedEpisodes(): void
    {
        //Arrange
        $season = new Season(1);

        $episode1 = new Episode(1);
        $episode1->setWatched(true);

        $episode2 = new Episode(2);

        $season->addEpisode($episode1);
        $season->addEpisode($episode1);

        //Act
        $watchedEpisodes = $season->watchedEpisodes();

        //Assert
        self::assertCount(1, $watchedEpisodes);
        self::assertSame($episode1, $watchedEpisodes->first());
    }
}
