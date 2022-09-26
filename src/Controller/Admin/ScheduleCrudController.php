<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
                ->addJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')
                ->addCssFile('/assets/styles/schedule.css')
                ->addHtmlContentToBody('<script src="/assets/js/scheduleCrud.js"></script>');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_NEW, Action::INDEX);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInPlural("Horarios")
            ->setEntityLabelInSingular("Horario")
            ->setDefaultSort(['branch' => 'asc', 'type' => 'asc'])
            ->setPageTitle(
                "detail",
                fn(Schedule $schedule) => (string) $schedule
            )
            ->setPageTitle(
                "edit",
                fn(Schedule $schedule) => (string) $schedule
            );
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('branch', 'Sucursal')->setSortable(true)->setColumns(3),
            ChoiceField::new('type', 'Tipo de horario')->setSortable(true)->setColumns(3)->setChoices(Schedule::TYPES),
            DateTimeField::new('openTime', 'Horario de apertura')->setSortable(true)->setColumns(3)->renderAsChoice()->setFormat('hh:mm aaa')->addCssClass('timeClass'),
            DateTimeField::new('closeTime', 'Horario de cierre')->setSortable(true)->setColumns(3)->renderAsChoice()->setFormat('hh:mm aaa')->addCssClass('timeClass'),
            FormField::addRow(),
            DateField::new('startsAt', 'Fecha inicial')->setSortable(true)->setColumns(3)->setFormat('dd MMM yyyy')->addCssClass('dateClass'),
            DateField::new('endsAt', 'Fecha final')->setSortable(true)->setColumns(3)->setFormat('dd MMM yyyy')->addCssClass('dateClass'),
        ];
    }
}
