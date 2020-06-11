<?php

namespace App\DataFixtures;

use App\Entity\UserInformation;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserInformationFixtures extends Fixture
{
    const ADMIN = [
        [
            'lastname' => 'Erpeldinger',
            'firstname' => 'Guillaume',
            'birthday' => '1992-07-10',
            'isHandicapped' => false,
            'isContactableTel' => true,
            'isContactableEmail' => true,
            'haveVehicle' => true,
        ],
        [
            'lastname' => 'Dureau',
            'firstname' => 'Ludovic',
            'birthday' => '1992-07-10',
            'isHandicapped' => false,
            'isContactableTel' => true,
            'isContactableEmail' => true,
            'haveVehicle' => true,
        ],
        [
            'lastname' => 'Adadain',
            'firstname' => 'Quentin',
            'birthday' => '1992-07-10',
            'isHandicapped' => false,
            'isContactableTel' => true,
            'isContactableEmail' => true,
            'haveVehicle' => true,
        ],
        [
            'lastname' => 'Ardilouze',
            'firstname' => 'Timothée',
            'birthday' => '1992-07-10',
            'isHandicapped' => false,
            'isContactableTel' => true,
            'isContactableEmail' => true,
            'haveVehicle' => true,
        ],
    ];

    const PREFIX_PHONE = 06;
    const PREFIX_PHONE_HOME = 05;
    const POSTAL_CODE = 33100;
    const CITY = 'Bordeaux';
    const COUNTRY = 'France';

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach (self::ADMIN as $i => $data) {
            $birthday = new DateTime($data['birthday']);
            $phoneNumber = self::PREFIX_PHONE . $faker->randomNumber(8, true);
            $homeNumber = self::PREFIX_PHONE_HOME . $faker->randomNumber(8, true);
            $admin = new UserInformation();
            $admin->setLastname($data['lastname'])
                ->setFirstname($data['firstname'])
                ->setBirthday($birthday)
                ->setPhoneNumber((int)$phoneNumber)
                ->setHomeNumber((int)$homeNumber)
                ->setPostalCode(self::POSTAL_CODE)
                ->setCity(self::CITY)
                ->setCountry(self::COUNTRY)
                ->setIsHandicapped($data['isHandicapped'])
                ->setIsContactableTel($data['isContactableTel'])
                ->setIsContactableEmail($data['isContactableEmail'])
                ->setHaveVehicle($data['haveVehicle'])
                ->setCurriculumVitae(uniqid());
            $this->addReference('adminInformation_' . ($i + 1), $admin);
            $manager->persist($admin);
        }

        for ($i = 1; $i < 21; $i++) {
            $lastname = $faker->lastName;
            $firstname = $faker->firstName;
            $birthday = $faker->dateTimeInInterval('-60 years', '+ 42 years', 'Europe/Paris');
            $phoneNumber = self::PREFIX_PHONE . $faker->randomNumber(8, true);
            $homeNumber = self::PREFIX_PHONE_HOME . $faker->randomNumber(8, true);
            $randomHandicapped = rand(1, 10000);
            $randomHandicapped = $randomHandicapped >= 9000; // Probability 90% - 10%
            $candidat = new UserInformation();
            $candidat->setLastname($lastname)
                ->setFirstname($firstname)
                ->setBirthday($birthday)
                ->setPhoneNumber((int)$phoneNumber)
                ->setHomeNumber((int)$homeNumber)
                ->setPostalCode(self::POSTAL_CODE)
                ->setCity(self::CITY)
                ->setCountry(self::COUNTRY)
                ->setIsHandicapped($randomHandicapped)
                ->setIsContactableTel((bool)rand(0, 1))
                ->setIsContactableEmail((bool)rand(0, 1))
                ->setHaveVehicle((bool)rand(0, 1))
                ->setCurriculumVitae(uniqid());
            $this->addReference('candidatInformation_' . $i, $candidat);
            $manager->persist($candidat);
        }

        $manager->flush();
    }
}