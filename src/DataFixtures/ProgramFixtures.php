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
        'Walking dead',
        'Friends',
        'Le Prince de Bel Air',
        'Hartley Coeurs à vifs',
        'Superman', 
        'Charmed'
        
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $title) {

        $program = new Program();
        $program->setTitle($title);
        $program->setSlug($this->input->generate($program->getTitle()));
        $program->setSummary('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_4'));
        $program->setYear(2001); 
        $program->setOwner($this->getReference('admin'));
        $program->addActor($this->getReference('actor_0'));
        $program->addActor($this->getReference('actor_1'));
        $program->addActor($this->getReference('actor_2'));
        $program->addActor($this->getReference('actor_3'));
        $manager->persist($program);
        $this->addReference('program_' . $key, $program);
        
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