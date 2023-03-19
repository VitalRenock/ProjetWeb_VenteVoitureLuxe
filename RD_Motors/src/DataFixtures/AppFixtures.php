<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Model;
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

        //region Création de Brand
        $brands = [];
        for($i=0;$i<5;$i++)
        {
            $brand = new Brand();
            $brand->setName($this->faker->company);
            $brands[]=$brand;
            $manager->persist($brand);
        }
        //endregion

        //region Création de Model
        $models=[];
        for($i=0;$i<10;$i++)
        {
            $model = new Model();
            $model->setName($this->faker->word)
                ->setBrand($brands[mt_rand(0,count($brands)-1)]);
            $models[] = $model;
            $manager->persist($model);
        }
        //endregion

        //region Création de Car
        $cars=[];
        for($i=0;$i<20;$i++)
        {
            $car = new Car();
            $car->setChassisNumber($this->faker->swiftBicNumber())
                ->setIsActive(mt_rand(0,1)==1?true :false)
                ->setConsumption(mt_rand(0,1)==1?mt_rand(0,25).' L/100Km' :mt_rand(0,25).' KW/100Km')
                ->setCylinderCapacity(mt_rand(500,2500))
                ->setCylinderNumber(mt_rand(4,24))
                ->setDoorNumber(mt_rand(0,1)==1?mt_rand(3,5) :null)
                ->setSeatNumber(mt_rand(0,1)==1?mt_rand(1,7) :null)
                ->setGears(mt_rand(5,10))
                ->setGearbox('ENUM A CHANGER')
                ->setFuelType('ENUM A CHANGER')
                ->setManufactureDate($this->randomDate('1970/01/01','2023/01/01'))
                ->setInterior($this->faker->text)
                ->setMileage(mt_rand(0,300000))
                ->setState('ENUM A CHANGER')
                ->setPower(mt_rand(100,1000))
                ->setPhoto($this->faker->imageUrl)
                ->setTransmissionType('ENUM A CHANGER')
                ->setTareWeight(mt_rand(900,3000))
                ->setModel($models[mt_rand(0,count($models)-1)]);
            $cars[]=$car;
            $manager->persist($car);
        }
        //endregion

        //region Création de Country
        $countries=[];
        for($i=0;$i<10;$i++)
        {
            $country = new Country();
            $country->setName($this->faker->country);
            $countries[]=$country;
            $manager->persist($country);
        }
        //endregion

        //region Création de City
        $cities=[];
        for($i=0;$i<15;$i++)
        {
            $city= new City();
            $city->setLocality($this->faker->city)
                ->setPostalCode((int)$this->faker->postcode)
                ->setCountry($countries[mt_rand(0,count($countries)-1)]);
            $cities[]=$city;
            $manager->persist($city);
        }
        //endregion

        //region Création de Address
        $addresses=[];
        for($i=0;$i<20;$i++)
        {
            $address = new Address();
            $address->setStreet($this->faker->streetAddress)
                ->setCity($cities[mt_rand(0,count($cities)-1)]);
            $addresses[]=$address;
            $manager->persist($address);
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
