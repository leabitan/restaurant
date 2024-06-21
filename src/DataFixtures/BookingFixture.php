<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookingFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $booking = new Booking();
            $booking->setBookingConfirmed($faker->boolean);
            $booking->setHourBooking($faker->dateTimeThisYear);
            $booking->setDateBooking($faker->dateTimeThisYear);
            $booking->setNameBooking($faker->name);
            $booking->setDiner($faker->boolean);
            $booking->setEmailBooking($faker->email);
            $booking->setPeopleNumber($faker->numberBetween(1, 10));
            $booking->setPhoneBooking($faker->phoneNumber);
            $booking->setComments($faker->sentence);

            $manager->persist($booking);
        }

        $manager->flush();
    }
}
