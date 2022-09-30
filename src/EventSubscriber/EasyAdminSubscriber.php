<?php

namespace App\EventSubscriber;

use App\Entity\PlayDate;
use App\Entity\Schedule;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

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

        if ($entity instanceof PlayDate){
            foreach ($entity->getPlayDateProducts() as $playDateProduct){
                $playDateProduct->setPrice( $playDateProduct->getProduct()->getPrice() );
            }
        }
    }
}