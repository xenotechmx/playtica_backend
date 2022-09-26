<?php

namespace App\Controller\Admin;

use App\Entity\PlayDate;
use App\Entity\Schedule;
use App\Form\PlayDateVisitorType;
use App\Controller\Admin\BranchCrudController;
use App\Controller\Admin\VisitorCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
                ->addJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')
                ->addHtmlContentToBody('<script src="/assets/js/playDateCrud.js"></script>');
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
            ->setSearchFields(['startAt', 'endAt', 'branch.name'])
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
            DateTimeField::new('startAt', 'Inicio')->setSortable(true)->setColumns(12)->renderAsChoice()->setFormat('dd MMM yyyy - hh:mm aaa')->setFormTypeOptions(['years'=>range((int) date('Y') +1 , (int) date('Y'))]),
            DateTimeField::new('endAt', 'Fin')->setSortable(true)->setColumns(12)->renderAsChoice()->setFormat('dd MMM yyyy - hh:mm aaa')->setFormTypeOptions(['years'=>range((int) date('Y') +1 , (int) date('Y'))]),
            FormField::addRow(),
            AssociationField::new('branch', 'Sucursal')->setCrudController(BranchCrudController::class)->setColumns(6),            
            ChoiceField::new('paymentStatus', 'Esatdo del pago')->setSortable(true)->setColumns(6)->setChoices(PlayDate::PAYMENT_STATUSES)->renderAsNativeWidget(),
            // AssociationField::new('visitors', 'Visitantes')
            //                 ->setCrudController(VisitorCrudController::class)
            //                 ->setColumns(12)
            //                 ->setFormTypeOptions([
            //                     'by_reference' => false,
            //                 ])
            //                 ->autocomplete(),
            
            FormField::addRow(),
            CollectionField::new(
				"playDateVisitors",
				"Visitantes"
			)
				->setEntryType(\App\Form\PlayDateVisitorType::class)
				->renderExpanded()
				->setColumns(6)
				->renderExpanded(),
            
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
