<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Car;
use App\Entity\Brand;
use App\Entity\Groupe;
use App\Repository\BrandRepository;
use App\Repository\GroupeRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private $groupeRepository;

    private $brandRepository;

    public function __construct(GroupeRepository $groupeRepository, BrandRepository $brandRepository)
    {
        $this->groupeRepository = $groupeRepository;
        $this->brandRepository = $brandRepository;
    }


    public function load(
        ObjectManager $manager
    ): void {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $groupe = new Groupe();

            $groupe->setName($faker->word);
            $groupe->setCountrie($faker->text);

            $manager->persist($groupe);

            $manager->flush();
        }

        for ($i = 0; $i < 8; $i++) {
            $brand  = new Brand();

            $brand->setName($faker->lastName);
            $brand->setCountrie($faker->firstName);

            $manager->persist($brand);

            $manager->flush();
        }

        for ($i = 0; $i < 15; $i++) {
            $car = new Car();

            $id_groupe = rand(21, 30);
            $id_brand = rand(17, 24);

            $groupe = $this->groupeRepository->find($id_groupe);
            $brand = $this->brandRepository->find($id_brand);

            $car->setName($faker->word);
            $car->setYear($faker->text);
            $car->setYear($this->faker->numberBetween($min=1999, $max=2022));
            $car->setEngine($faker->text);
            $car->setDescription($faker->text);
            $car->setGroupe($groupe);
            $car->setBrand($brand);

            $manager->persist($car);
        }



        $manager->flush();
    }
}
