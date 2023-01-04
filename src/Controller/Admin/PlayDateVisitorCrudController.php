<?php

namespace App\Controller\Admin;

use App\Entity\PlayDateVisitor;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlayDateVisitorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlayDateVisitor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('visitor', 'Visitante')->renderAsEmbeddedForm(
                VisitorCrudController::class
            ),
        ];
    }    
}
