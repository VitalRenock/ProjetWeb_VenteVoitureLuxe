<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Model;
use App\Entity\Order;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserAddress;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Monolog\DateTimeImmutable;
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
        $user = new User();
        $user->setUsername('test')
            ->setFirstName('test')
            ->setLastName('test')
            ->setPassword(password_hash('test',PASSWORD_BCRYPT))
            ->setPhone('test')
            ->setEmail('test@test.test')
            ->setIsActive(true)
            ->setBirthday($this->randomDate('1910/01/01','2004/01/01'))
            ->setRole($roles[2]);
        $manager->persist($user);
        $users=[];
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
                $users[] = $user;
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
        $gearbox = ['Manuelle','Automatique','Séquentielle'];
        $fuelType = ['Essence','Diesel','Electrique','Plug-In-Hybrid','Hybrid Rechargeable','Hygrogène'];
        $state = ['Neuf','Occasion'];
        $transmissiontype = ['Avant','Arrière','4x4'];
        for($i=0;$i<20;$i++)
        {
            $car = new Car();
            $car->setChassisNumber($this->faker->swiftBicNumber())
                ->setIsActive(mt_rand(0,2)==1?false :true)
                ->setConsumption(mt_rand(0,1)==1?mt_rand(0,25).' L/100Km' :mt_rand(0,25).' KW/100Km')
                ->setCylinderCapacity(mt_rand(500,2500))
                ->setCylinderNumber(mt_rand(4,24))
                ->setDoorNumber(mt_rand(0,1)==1?mt_rand(3,5) :null)
                ->setSeatNumber(mt_rand(0,1)==1?mt_rand(1,7) :null)
                ->setGears(mt_rand(5,10))
                ->setGearbox($gearbox[mt_rand(0,count($gearbox)-1)])
                ->setFuelType($fuelType[mt_rand(0,count($fuelType)-1)])
                ->setManufactureDate($this->randomDate('1970/01/01','2023/01/01'))
                ->setInterior($this->faker->text)
                ->setMileage(mt_rand(0,300000))
                ->setState($state[mt_rand(0,count($state)-1)])
                ->setPower(mt_rand(100,1000))
                ->setPhoto($this->faker->imageUrl)
                ->setTransmissionType($transmissiontype[mt_rand(0,count($transmissiontype)-1)])
                ->setTareWeight(mt_rand(900,3000))
                ->setModel($models[mt_rand(0,count($models)-1)])
                ->setPrice(mt_rand(5000,600000));
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
        //region Création de UserAddress
        $addressType = ['Domicile','Livraison','Facturation'];
        $userAdresses=[];
        $userAdressExistant = false;
            for($i=0;$i<15;$i++)
            {
                $userAdress = new UserAddress();
                $userAdress->setAddressType($addressType[mt_rand(0,2)])
                    ->setAddress($addresses[mt_rand(0,count($addresses)-1)])
                    ->setUser($users[mt_rand(0,count($users)-1)]);
                if($i>0)
                {
                    foreach ($userAdresses as $u ) //éviter qu'on se retrouve avec les trois aattributs les memes plusieurs fois
                    {
                        if($userAdress->getUser() == $u->getUser() && $userAdress->getAddress() == $u->getAddress() && $userAdress->getAddressType() == $u->getAddressType())
                        {
                            $userAdressExistant = true;
                            break;
                        }
                        $userAdressExistant=false;
                    }
                    if($userAdressExistant == false)
                    {
                        $userAdresses[] = $userAdress;
                        $manager->persist($userAdress);
                    }

                }
            }
        //endregion

        //region Création des Order
        $prixTotal = 0;

        $payType=['Cash','Visa','Mastercard'];
        for($i=0;$i<5;$i++)
        {
            $carsInOrder=[];
            $order = new Order();
            $order->setUser($users[mt_rand(0,count($users)-1)])
                ->setOrderDate($this->randomDate('2020/01/01','2023/01/01'))
                ->setBillingDate(mt_rand(0,1)==1?$this->randomDate($order->getOrderDate()->format('Y-m-d H:i:s'),'2023/01/01'):null)
                ->setDeliveryDate($this->randomDeliveryDate($order))
                ->setOrderStatus($this->randomOrderStatus($order))
                ->setUser($users[mt_rand(0,count($users)-1)]);
            for($i=0;$i<mt_rand(1,7);$i++)
            {
                $carOk = true;
                $random = mt_rand(0,count($cars)-1);
                if(!empty($carsInOrder))
                {
                    foreach ($carsInOrder as $c)
                    {
                        if($cars[$random] == $c)
                            $carok = false;
                    }
                }

                if($cars[$random]->isIsActive() == false && $carOk == true)
                {
                    $order->addCar($cars[$random]);
                    $carsInOrder[] = $cars[$random];
                }
                elseif($cars[$random]->isIsActive() == true && $carOk == true &&$order->getOrderStatus() == 'Annulé')
                {
                    $order->addCar($cars[$random]);
                    $carsInOrder[] = $cars[$random];
                }
            }
            foreach ($carsInOrder as $c)
            {
                $prixTotal+= $c->getPrice();
            }
            $order->setPrice($prixTotal);
            $manager->persist($order);

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

    function randomDeliveryDate(Order $order) : ?\DateTime //Si Billing Date = null, Delivery Date doit etre null
    {
        if($order->getBillingDate() == null)
        {
            return null;
        }
        return mt_rand(0,1)==1?$this->randomDate($order->getBillingDate()->format('Y-m-d H:i:s'),'2023/01/01'):null;
    }
    function randomOrderStatus(Order $order) : string //Vérification d'un status cohérent en fonction des différentes dates
    {
        $orderStatus = ['Créé','Payé','Facturé','Livré','Annulé'];
        if($order->getBillingDate() == null)
        {
            return $orderStatus[mt_rand(0,1) == 1?mt_rand(0,1) : 4 ];
        }
        if($order->getOrderDate() == null)
        {
            return $orderStatus[2];
        }
        return $orderStatus[3];
    }
}
