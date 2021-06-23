<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    private $input;

    public function __construct(Slugify $input)
    {
        $this->input = $input;
    }


    const PROGRAMS =[
        ['title' => 'walking dead', 'summary' => 'Résumé', 'poster' => 'Une image ici', 'year' => '1990', 'country' => 'USA'],
        ['title' => 'Friends', 'summary' => 'Résumé', 'poster' => 'Une image ici', 'year' => '1900', 'country' => 'USA'],
        ['title' => 'Le Prince de Bel Air', 'summary' => 'Résumé', 'poster' => 'Une image ici', 'year' => '1990', 'country' => 'USA'],
        ['title' => 'Superman', 'summary' => 'Résumé', 'poster' => 'Une image ici', 'year' => '1990', 'country' => 'USA'],
        ['title' => 'charmed', 'summary' => 'Résumé', 'poster' => 'Une image ici', 'year' => '2018', 'country' => 'USA'],
    ];


    

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $row => $value) {

        $program = new Program();
        $program->setTitle($value['title']);
        $program->setSlug($this->input->generate($value['title']));
        $program->setSummary($value['summary']);
        $program->setPoster($value['poster']);
        $program->setCategory($this->getReference('category_0'));
        $program->setYear($value['year']);
        $program->setOwner($this->getReference('admin'));        
        $manager->persist($program);
        $this->addReference('program_' . $row, $program);
        
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
          UserFixtures::class,

        ];
    }


}