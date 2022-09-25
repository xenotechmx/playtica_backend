<?php

namespace App\Controller\Admin;

use App\Entity\PlayDate;
use App\Controller\Admin\BranchCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlayDateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlayDate::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInPlural("Citas de juego")
            ->setEntityLabelInSingular("Cita de juego")
            ->setSearchFields(['startAt', 'endAt', 'branch' ])
            ->setPageTitle(
                "detail",
                fn(PlayDate $playDate) => (string) $playDate
            )
            ->setPageTitle(
                "edit",
                fn(PlayDate $playDate) => (string) $playDate
            );
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('startAt', 'Inicio')->setSortable(true)->setColumns(4)->setFormat('dd MMM yyyy - hh:mm aaa'),
            DateTimeField::new('endAt', 'Fin')->setSortable(true)->setColumns(4)->setFormat('dd MMM yyyy - hh:mm aaa'),
            FormField::addRow(),
            AssociationField::new('branch', 'Sucursal')->setCrudController(BranchCrudController::class)->setColumns(6),            
            // AssociationField::new('visitors', 'Visitantes')
            //                 ->setCrudController(VisitorCrudController::class)
            //                 ->setColumns(12)
            //                 ->setFormTypeOptions([
            //                     'by_reference' => false,
            //                 ])
            //                 ->autocomplete(),

            CollectionField::new(
				"playDateVisitors",
				"Visitantes"
			)
				->setEntryType(\App\Form\PlayDateVisitorType::class)
				->renderExpanded()
				->setColumns(6)
				->renderExpanded()
				->hideOnIndex(),
            
        ];
    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('startAt')
            ->add('endAt')
            ->add('branch')
            ->add('playDateVisitors');
    }

}
