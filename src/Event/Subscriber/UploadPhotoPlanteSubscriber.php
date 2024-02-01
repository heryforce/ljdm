<?php

namespace App\Event\Subscriber;

use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UploadPhotoPlanteSubscriber implements EventSubscriberInterface
{
    private $rs;

    public function __construct(RequestStack $requestStack)
    {
        $this->rs = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UploadEvents::postUpload('photos') => ['onPostUploadPhoto'],
            UploadEvents::postUpload('carousel') => ['onPostUploadCarousel'],
        ];
    }

    public function onPostUploadPhoto(PostUploadEvent $event)
    {
        $session = $this->rs->getSession();
        $fileName = $event->getFile()->getFilename();
        $tab = $session->get('files', []);
        $tab[] = $fileName;
        $session->set('files', $tab);
    }

    public function onPostUploadCarousel(PostUploadEvent $event)
    {
        $session = $this->rs->getSession();
        $fileName = $event->getFile()->getFilename();
        $tab = $session->get('carousel', []);
        $tab[] = $fileName;
        $session->set('carousel', $tab);
    }
}
