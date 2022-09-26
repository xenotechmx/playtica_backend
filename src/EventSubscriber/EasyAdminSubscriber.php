<?php

namespace App\EventSubscriber;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDatesAndTimesSchedule'],
        ];
    }

    public function setDatesAndTimesSchedule(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Schedule) {
            if($entity->getType() >= 1 && $entity->getType() <= 7 ){ //weekdays
                $entity->setStartsAt(null);
                $entity->setEndsAt(null);
            }
            if($entity->getType() == 9){ //closed
                $entity->setOpenTime(null);
                $entity->setCloseTime(null);
            }
        }
    }
}