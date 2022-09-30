<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions            
            ->disable(Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setSearchFields(['name, price', 'branch.name'])
            ->setEntityLabelInPlural("Productos")
            ->setEntityLabelInSingular("Producto")
            ->setDefaultSort(['branch' => 'asc', 'price' => 'asc'])
            ->setPageTitle(
                "detail",
                fn(Product $schedule) => (string) $schedule
            )
            ->setPageTitle(
                "edit",
                fn(Product $schedule) => (string) $schedule
            );
    }
    
    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('name')
            ->add('price')
            ->add('branch');
    }

    public function configureFields(string $pageName): iterable
    {
        return [                      
            BooleanField::new('active', 'Disponible')->setSortable(true)->setColumns(3),
            FormField::addRow(),
            TextField::new('name', 'Producto')->setSortable(true)->setColumns(4),
            AssociationField::new('branch', 'Sucursal')->setSortable(true)->setColumns(4),
            MoneyField::new('price', 'Precio')->setSortable(true)->setColumns(4)->setCurrency('MXN'),
        ];
    }

}
