<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Service\Slugify;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        ['number' => 1, 'year' => 2014, 'description' => ' description '],
        ['number' => 2, 'year' => 2015, 'description' => ' description '],
        ['number' => 3, 'year' => 2016, 'description' => ' description '],
        ['number' => 4, 'year' => 2017, 'description' => ' description '],
        ['number' => 5, 'year' => 2018, 'description' => ' description ']
    ];
       
       
    

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $row => $value) {
            $season = new Season();
            $season->setProgram($this->getReference('program_0'));
            $season->setNumber($value['number']);
            $season->setYear($value['year']);
            $season->setdescription($value['description']);
            $this->addReference('season_' . $row, $season);
            $manager->persist($season);

        }  
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }

}