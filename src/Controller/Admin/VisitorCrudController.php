<?php

namespace App\Controller\Admin;

use App\Entity\Visitor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VisitorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visitor::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addJsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js')
			->addHtmlContentToBody('<script src="/assets/js/moment.js"></script>')
			->addHtmlContentToBody('<script src="/assets/js/visitorCrud.js"></script>');
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
            ->setEntityLabelInPlural("Visitantes")
            ->setEntityLabelInSingular("Visitante")
            ->setSearchFields(['firstName', 'lastName'])
            ->setPageTitle(
                "detail",
                fn(Visitor $visitor) => (string) $visitor
            )
            ->setPageTitle(
                "edit",
                fn(Visitor $visitor) => (string) $visitor
            );
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [            
            TextField::new("firstName", "Nombre(s)")->setSortable(true)->setColumns(4),
            TextField::new("lastName", "Apellido(s)")->setSortable(true)->setColumns(4),
            DateField::new("birthday", "Fecha de nacimiento")->setSortable(true)->setColumns(4)->renderAsChoice()->setFormTypeOptions(['years'=>range((int) date('Y') - 70, (int) date('Y'))]),            
            ChoiceField::new("gender", "Género")->setSortable(true)->setColumns(4)->autocomplete()->setChoices([
                Visitor::UNDEFINED => Visitor::GENDER_UNDEFINED,
                Visitor::FEMALE => Visitor::GENDER_FEMALE,
                Visitor::MALE => Visitor::GENDER_MALE
            ]),
            TextField::new("zipcode", "Código postal")->setSortable(true)->setColumns(4),
            ChoiceField::new("type", "Tipo de visitante")->setSortable(true)->setColumns(4)->setChoices([
                Visitor::INFANT => Visitor::TYPE_INFANT,
                Visitor::ADULT => Visitor::TYPE_ADULT
            ])->renderAsNativeWidget(),
        ];
    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add('firstName')
            ->add('lastName')
            ->add('birthday')            
            ->add('zipcode');
    }
    

}
