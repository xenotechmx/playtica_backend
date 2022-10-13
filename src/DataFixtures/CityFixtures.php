<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{

    private $cities = ['Abasolo', 'Agualeguas', 'Los Aldamas', 'Allende', 'Anáhuac', 'Apodaca', 'Aramberri', 'Bustamante', 'Cadereyta Jiménez', 'El Carmen', 'Cerralvo', 'Ciénega de Flores', 'China', 'Doctor Arroyo', 'Doctor Coss', 'Doctor González', 'Galeana', 'García', 'San Pedro Garza García', 'General Bravo', 'General Escobedo', 'General Terán', 'General Treviño', 'General Zaragoza', 'General Zuazua', 'Guadalupe', 'Los Herreras', 'Higueras', 'Hualahuises', 'Iturbide', 'Juárez', 'Lampazos de Naranjo', 'Linares', 'Marín', 'Melchor Ocampo', 'Mier y Noriega', 'Mina', 'Montemorelos', 'Monterrey', 'Paras', 'Pesquería', 'Los Ramones', 'Rayones', 'Sabinas Hidalgo', 'Salinas Victoria', 'San Nicolás de los Garza', 'Hidalgo', 'Santa Catarina', 'Santiago', 'Vallecillo', 'Villaldama'];

    public function load(ObjectManager $manager): void
    {

        foreach ($this->cities as $city){
            $cityObj = new City();
            $cityObj->setName($city);
            $manager->persist($cityObj);
        }

        $manager->flush();
    }
}
