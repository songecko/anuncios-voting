<?php

namespace Anuncios\AnuncioBundle\Uploader;

use Anuncios\AnuncioBundle\Model\ImageInterface;

interface ImageUploaderInterface
{
    public function upload(ImageInterface $image);
    public function remove($path);
}
