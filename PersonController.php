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

    $peopleByYear = $entityManager->getRepository(Person::class)->createQueryBuilder('p')
        ->select('p.birthYear as year, COUNT(p.id) as people_count')
        ->where('p.birthYear <= :currentYear AND (p.deathYear IS NULL OR p.deathYear >= :currentYear)')
        ->setParameter('currentYear', 2021)
        ->groupBy('year')
        ->orderBy('people_count', 'DESC')
        ->getQuery()
        ->getResult();

    $maxPeopleCount = $peopleByYear[0]['people_count'];
    $yearsWithMaxPeople = [];

    foreach ($peopleByYear as $personData) {
        if ($personData['people_count'] === $maxPeopleCount) {
            $yearsWithMaxPeople[] = $personData['year'];
        } else {
            break;
        }
    }

    return new Response("Годы, когда жило максимальное количество людей: " . implode(', ', $yearsWithMaxPeople));
}
}
