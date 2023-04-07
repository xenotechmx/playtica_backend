<?php

namespace App\Controller\Admin;

use App\Entity\PlayDate;
use App\Controller\Admin\BranchCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlayDateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlayDate::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
                ->addJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')
                ->addHtmlContentToBody('<script src="/assets/js/moment.js"></script>')
                ->addHtmlContentToBody('<script src="/assets/js/app.js"></script>')
                ->addHtmlContentToBody('<script src="/assets/js/playDateCrud.js"></script>');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions            
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW)
            ->disable(Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setEntityLabelInPlural("Citas de juego")
            ->setEntityLabelInSingular("Cita de juego")
            ->setSearchFields(['startsAt', 'endsAt', 'branch.name'])
            ->setDefaultSort(['id' => 'DESC'])
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
            IntegerField::new('id', 'Folio')->setSortable(true)->hideOnForm(),            
            AssociationField::new('branch', 'Sucursal')->setColumns(3)->setCrudController(BranchCrudController::class)->setColumns(3),
            DateField::new('date', 'Fecha')->setSortable(true)->setColumns(3)->setFormat('dd MMM yyyy')->setFormTypeOptions(['years'=>range((int) date('Y') +1 , (int) date('Y'))]),

            FormField::addRow(),

            ChoiceField::new('hours', 'Horas')->setColumns(3)->setChoices([1=>1, 2=>2, 'Todo el día'=>0])->renderAsNativeWidget()->onlyOnForms(),
            TimeField::new('startsAt', 'Inicia')->setSortable(true)->setColumns(3)->renderAsChoice()->setFormat('hh:mm aaa'),            
            TimeField::new('endsAt', 'Finaliza')->setSortable(true)->setColumns(3)->renderAsChoice()->setFormat('hh:mm aaa'),
                        
            ChoiceField::new('paymentStatus', 'Pago')->setSortable(true)->setColumns(2)->setChoices(PlayDate::PAYMENT_STATUSES)->renderAsNativeWidget(),
                        
            FormField::addRow(),

            AssociationField::new('playDateVisitors', 'Visitantes')
                    //->setCrudController(VisitorCrudController::class)
                    ->setColumns(6)
                    ->setFormTypeOptions([
                        'by_reference' => false,
                    ])
                    ->autocomplete(),

            // AssociationField::new('playDateProducts', 'Productos')
            //         //->setCrudController(VisitorCrudController::class)
            //         ->setColumns(6)
            //         ->setFormTypeOptions([
            //             'by_reference' => false,
            //         ])
            //         ->autocomplete(),

            NumberField::new('price', 'Precio')->setSortable(true)->setNumDecimals(2)->setNumberFormat('$%.2d')->hideOnForm(),
            
        ];
    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('startsAt')
            ->add('endsAt')
            ->add('branch')
            ->add('playDateVisitors');
    }

}
