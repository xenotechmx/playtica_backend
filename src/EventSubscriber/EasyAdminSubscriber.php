<?php

namespace App\EventSubscriber;

use App\Entity\PlayDate;
use App\Entity\Schedule;
use App\Repository\VisitorRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\PlayDateCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;


class EasyAdminSubscriber implements EventSubscriberInterface
{

    private AdminUrlGenerator $adminUrlGenerator;
    private AdminContextProvider $adminContextProvider;
    private $visitorRepository;
        
    public function __construct(AdminUrlGenerator $adminUrlGenerator, AdminContextProvider $adminContextProvider, VisitorRepository $visitorRepository)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->adminContextProvider = $adminContextProvider;
        $this->visitorRepository = $visitorRepository;        
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['beforePesrsistEvents'],
        ];
    }

    public function beforePesrsistEvents(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        //setting times for schedules
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
        //end of setting times for schedules

        //saving playdates
        if ($entity instanceof PlayDate){
            $request = $this->adminContextProvider->getContext()->getRequest()->request->all();
            $query = $this->adminContextProvider->getContext()->getRequest()->query->all();

            if($query['crudAction'] === 'new'){
                $result = $entity->binPlayDateVisitor($entity, $request, $this->visitorRepository);
            }
        }
        //end of saving playdates
    }
}