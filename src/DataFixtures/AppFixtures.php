<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Cour;
use App\Entity\Section;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::Create('fr_FR');
        for ($u = 0; $u < 10; $u++) {
            $category = new Category();
            $category
                ->setTitle($faker->word())
                ->setSlug($faker->slug(1, false))
            ;
            $manager->persist($category);


            $user = new User();
            $password = $this->hasher->hashPassword($user, '1234567890');
            $user
                ->setLastName($faker->lastName())
                ->setFirstName($faker->firstName())
                ->setSpeciality($faker->jobTitle())
                ->setEmail($faker->email())
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setPassword($password)
            ;
            $manager->persist($user);

            for($c = 0; $c < mt_rand(0, 5); $c++) {
                $cour = new Cour();
                $cour
                    ->setTitle($faker->sentence())
                    ->setSlug($faker->slug())
                    ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                    ->setUser($user)
                    ->setBanner($faker->imageUrl(640, 480, 'animals', true))
                    ->setPrice(mt_rand(5, 299))
                    ->setCategory($category)
                ;

                $manager->persist($cour);

                for($s = 0; $s < mt_rand(0, 20); $s++) {
                    $section = new Section();
                    $section
                        ->setTitle($faker->sentence())
                        ->setSlug($faker->slug)
                        ->setCour($cour)
                    ;

                    $manager->persist($section);

                    for($v = 0; $v < mt_rand(0, 20); $v++) {
                        $video = new Video();
                        $video
                            ->setTitle($faker->sentence())
                            ->setSlug($faker->slug())
                            ->setLink($faker->imageUrl(640, 480, 'animals', true))
                            ->setCour($cour)
                            ->setUser($user)
                            ->setSection($section)
                            ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                        ;

                        $manager->persist($video);
                    }
                }
            }
        }

        $manager->flush();
    }
}
