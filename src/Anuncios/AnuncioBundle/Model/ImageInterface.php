<?php

namespace Anuncios\AnuncioBundle\Model;

use SplFileInfo;
use DateTime;

interface ImageInterface
{
    public function getId();
    public function hasFile();
    public function getFile();
    public function setFile(SplFileInfo $file);
    public function getPath();
    public function setPath($path);
}
