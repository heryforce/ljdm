<?php

namespace App\Namer;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\Uid\Uuid;

class PhotoNamer implements NamerInterface
{
    public function __construct()
    {
    }

    public function name(FileInterface $file)
    {
        return Uuid::v1() . '.' . $file->getExtension();
    }
}