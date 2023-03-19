<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private Generator $faker;  //Permer de générer des noms "logiques"
    public function __construct()
    {
        //Création de l'objet Faker
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        //region Création des "Roles"
        $roles = [];
        $role = new Role();
        $role->setName('Client');
        $roles[] = $role;
        $manager->persist($role);
        $role = new Role();
        $role->setName('Employee');
        $roles[] = $role;
        $manager->persist($role);
        $role = new Role();
        $role->setName('Administrator');
        $roles[] = $role;
        $manager->persist($role);

        //endregion
        //region Création des "Users"

        // ->setPassword(password_hash('password',PASSWORD_BCRYPT))
            for($i=0;$i<5;$i++)
            {
                $user = new User();
                $user->setUsername($this->faker->userName)
                    ->setFirstName($this->faker->firstName)
                    ->setLastName($this->faker->lastName)
                    ->setPassword(password_hash('password',PASSWORD_BCRYPT))
                    ->setPhone(mt_rand(0,1)==1?$this->faker->phoneNumber :null)
                    ->setEmail($this->faker->email)
                    ->setIsActive(mt_rand(0,1)==1?true :false)
                    ->setBirthday($this->randomDate('1910/01/01','2004/01/01'))
                    ->setRole($roles[mt_rand(0,count($roles)-1)]);
                $manager->persist($user);

            }
        //endregion
        $manager->flush();
    }
    // Find a randomDate between $start_date and $end_date
    function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return  date_create(date('Y-m-d H:i:s', $val));
    }
}
