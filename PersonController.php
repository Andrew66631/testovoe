<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends AbstractController
{
    public function getManyPeopleToYear(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        for ($i = 0; $i < 100; $i++) {
            $person = new Person();
            $person->setBirthYear(rand(1900, 2000));
            $person->setDeathYear(rand($person->getBirthYear(), 2021));
            $entityManager->persist($person);
        }

        $entityManager->flush();

        $peopleByYear = $entityManager->getRepository(Person::class)->createQueryBuilder('p')
            ->select('p.birthYear, COUNT(p.id) as people_count')
            ->groupBy('p.birthYear')
            ->orderBy('people_count', 'DESC')
            ->getQuery()
            ->getResult();

        $yearWithMostPeople = $peopleByYear[0]['birthYear'];

        return new Response("Год, когда жило больше всего людей: " . $yearWithMostPeople);
    }
}
