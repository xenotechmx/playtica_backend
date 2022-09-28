<?php

namespace App\Controller\Admin;

use App\Entity\Branch;
use App\Form\PlayDateVisitorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BranchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Branch::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
                ->addCssFile('/assets/styles/branch.scss');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::DELETE)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInPlural("Sucursales")
            ->setEntityLabelInSingular("Sucursal")
            ->setPageTitle(
                "detail",
                fn(Branch $branch) => (string) $branch
            )
            ->setPageTitle(
                "edit",
                fn(Branch $branch) => (string) $branch
            );
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [            
            TextField::new("name", "Nombre de la sucursal")->setSortable(true)->setColumns(4),
            TelephoneField::new("phone", "Teléfono")->setSortable(true)->setColumns(4),
            IntegerField::new("maxVisitors", "Número máximo de visitantes")->setSortable(true)->setColumns(4),
            TextareaField::new("address", "Dirección")->setColumns(6)->hideOnIndex(),
            FormField::addRow(),
            CollectionField::new("fares", "Tarifas para menores" )
                ->setEntryType(\App\Form\FareType::class)
                ->setEntryIsComplex(true)
				->setColumns(6)
				->renderExpanded()
                ->hideOnIndex(),
            CollectionField::new("adultFares", "Tarifas para adultos" )
                ->setEntryType(\App\Form\AdultFareType::class)
                ->setEntryIsComplex(true)
				->setColumns(6)
				->renderExpanded()
                ->hideOnIndex(),
        ];
    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('name')
            ->add('phone')
            ->add('maxVisitors')
            ->add('address');
    }
}
