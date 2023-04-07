<?php

namespace App\EventSubscriber;

use App\Entity\PlayDate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;

class PlayDateSubscriber implements EventSubscriberInterface
{
    public function onAfterEntityPersistedEvent(AfterEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        //sending email
        if ($entity instanceof PlayDate) {
            $entity->sendEmail();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => 'onAfterEntityPersistedEvent',
        ];
    }
}
