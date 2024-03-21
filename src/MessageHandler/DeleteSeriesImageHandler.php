<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SeriesWasDeleted;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsMessageHandler]
class DeleteSeriesImageHandler{

    public function __construct(private ParameterBagInterface $parameterBag){

    }

    public function __invoke(SeriesWasDeleted $message){

        $coverImagePath = $message->series->getCoverImagePath();
        unlink($this->paramterBag->get('cover_image_directory') . DIRECTORY_SEPARATOR . $coverImagePath);

    }

}