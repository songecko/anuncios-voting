<?php

namespace Anuncios\AnuncioBundle\EventListener;

use Anuncios\AnuncioBundle\Model\ImageInterface;
use Anuncios\AnuncioBundle\Uploader\ImageUploaderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ImageUploadListener
{
    protected $uploader;

    public function __construct(ImageUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }
    
    public function uploadImage(GenericEvent $event)
    {
        $subject = $event->getSubject();

        if (!$subject instanceof ImageInterface) {
            throw new \InvalidArgumentException('ImageInterface expected.');
        }

        if ($subject->hasFile()) {
            $this->uploader->upload($subject);
        }  
    }
}
