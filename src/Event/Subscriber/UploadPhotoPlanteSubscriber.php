<?php

namespace App\Event\Subscriber;

use Oneup\UploaderBundle\Event\PostUploadEvent;
use Oneup\UploaderBundle\UploadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UploadPhotoPlanteSubscriber implements EventSubscriberInterface
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UploadEvents::postUpload('photos') => ['onPostUpload'],
        ];
    }

    public function onPostUpload(PostUploadEvent $event)
    {
        $fileName = $event->getFile()->getFilename();
        $tab = $this->session->get('files', []);
        $tab[] = $fileName;
        $this->session->set('files', $tab);
    }
}
