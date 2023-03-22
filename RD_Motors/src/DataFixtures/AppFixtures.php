<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\City;
use App\Entity\Color;
use App\Entity\Country;
use App\Entity\Model;
use App\Entity\Order;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserAddress;
use App\Enum\PaymentType;
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
                    ->setIsActive(mt_rand(0,1)==1)
                    ->setBirthday($this->randomDate('1910/01/01','2004/01/01'))
                    ->setRole($roles[mt_rand(0,count($roles)-1)]);
                $users[] = $user;
                $manager->persist($user);

            }
        //endregion

        //region Création de Brand
        $brands = [];
            $brandNames = ['Porsche', 'Ferrari', 'Tesla', 'Mazda','Mustang', 'Lamborghini','Bugatti','Maserati','Alpine','Rolls-Royce','Aston Martin','Bentley'];
        for($i=0;$i<count($brandNames)-1;$i++)
        {
            $brand = new Brand();
            $brand->setName($brandNames[$i]);
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

        //region Création de color
        $colors=[];
        $colorType = ['NORMAL','METALLIC','MAT'];
        for($i=0;$i<10;$i++)
        {
            $color = new Color();
            $color->setName($this->faker->colorName)
                ->setColorType($colorType[mt_rand(0,count($colorType)-1)]);
            $colors[] = $color;
            $manager->persist($color);
        }

        //endregion

        //region Création de Car
        $cars=[];
        $fuelType = ['PETROL','DIESEL','ELECTRIC','PLUG_IN_HYBRID','HYBRID'];
        $state = ['NEW','SECOND_HAND'];
        $transmissiontype = ['FRONT','REAR','FOURBYFOUR'];
        for($i=0;$i<50;$i++)
        {
            $car = new Car();
            $car->setChassisNumber($this->faker->swiftBicNumber())
                ->setFuelType($fuelType[mt_rand(0,count($fuelType)-1)])
                ->setIsActive(mt_rand(0,2)==1)
                ->setConsumption($this->randomConsumption($car))
                ->setCylinderCapacity($this->randomCylinderCapacity($car))
                ->setCylinderNumber($this->randomCylinderNumber($car))
                ->setDoorNumber(mt_rand(0,1)==1?mt_rand(3,5) :null)
                ->setSeatNumber(mt_rand(0,1)==1?mt_rand(1,7) :null)
                ->setGears(mt_rand(5,10))
                ->setGearbox($this->randomGearbox($car))
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
            for($j=0;$j<mt_rand(1,3);$j++)
            {
                $car->addColor($colors[mt_rand(0,count($colors)-1)]);
            }
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
        $addressType = ['HOME','DELIVERY','BILLING'];
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
                    if(!$userAdressExistant)
                    {
                        $userAdresses[] = $userAdress;
                        $manager->persist($userAdress);
                    }

                }
            }
        //endregion

        //region Création des Order
        $prixTotal = 0;
        $carsInOrder=[];
        $paymentType=['CASH','VISA','MASTERCARD','TRANSFER'];
        for($i=0;$i<50;$i++)
        {
            foreach ($carsInOrder as $c)
            {
                unset($c);
            }
            reset($carsInOrder);

            $order = new Order();
            $order->setUser($users[mt_rand(0,count($users)-1)])
                ->setOrderDate($this->randomDate('2020/01/01','2023/01/01'))
                ->setBillingDate(mt_rand(0,1)==1?$this->randomDate($order->getOrderDate()->format('Y-m-d H:i:s'),'2023/01/01'):null)
                ->setDeliveryDate($this->randomDeliveryDate($order))
                ->setUser($users[mt_rand(0,count($users)-1)])
                ->setPaymentType($paymentType[mt_rand(0,count($paymentType)-1)])
                ->setOrderStatus($this->randomOrderStatus($order));
            $carNumber = 0;
            do
            {
                    $random = mt_rand(0,count($cars)-1);

                if(!$cars[$random]->isIsActive())
                {
                    $order->addCar($cars[$random]);
                    $carsInOrder[] = $cars[$random];
                    $carNumber++;
                }
                elseif($cars[$random]->isIsActive()&& $order->getOrderStatus() == 'CANCELLED')
                {
                    $order->addCar($cars[$random]);
                    $carsInOrder[] = $cars[$random];
                }
            }while($carNumber<mt_rand(1,3));
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
    public function randomConsumption(Car $car) : string
    {
        if($car->getFuelType() == 'DIESEL' || $car->getFuelType() == 'PETROL')
        {
            return mt_rand(5,20).' L/100KM';
        }
        if($car->getFuelType() == 'ELECTRIC')
        {
            return mt_rand(4,25).' KW/100KM';
        }
        return mt_rand(2,10).' L/100KM'.' + '.mt_rand(4,20).' KW/100KM';
    }
    public function randomCylinderCapacity(Car $car) : ?int
    {
        if($car->getFuelType() == 'ELECTRIC')
        {
            return null;
        }
        return mt_rand(500,2500);
    }
    public function randomCylinderNumber(Car $car) : ?int
    {
        if($car->getFuelType() == 'ELECTRIC')
        {
            return null;
        }
        return mt_rand(4,20);
    }
    public function randomGearbox(Car $car) : string
    {
        $gearbox = ['MANUAL','AUTOMATIC','CVT'];
        if($car->getFuelType() == 'PETROL'|| $car->getFuelType() == 'DIESEL')
        {
            return $gearbox[mt_rand(0,count($gearbox)-1)];
        }
        return $gearbox[1];
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
        $orderStatus = ['CREATED','PAID','INVOICED','DELIVERED','CANCELLED'];
        if(!$order->getUser()->isIsActive()&&$order->getDeliveryDate() != null)
        {
            return $orderStatus[3];
        }
        if(!$order->getUser()->isIsActive()&&$order->getBillingDate() == null)
        {
            return $orderStatus[4];
        }
        if($order->getBillingDate() == null)
        {
            return $orderStatus[mt_rand(0,1) == 1?mt_rand(0,1): 4];
        }
        if($order->getDeliveryDate() == null)
        {
            return $orderStatus[2];
        }
        return $orderStatus[3];
    }
}
