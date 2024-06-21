<?php

namespace App\Tests;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookingTest extends KernelTestCase
{
    public function testEntityIsValid(): void
    {
        // (1) boot the Symfony kernel
        $kernel = self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $booking = new Booking();
        $booking->setBookingConfirmed(true);
        $booking->setHourBooking(new \DateTime('now'));
        $booking->setDateBooking(new \DateTime('now'));
        $booking->setNameBooking("testName");
        $booking->setDiner(True);
        $booking->setEmailBooking("testEmail@testemail.com");
        $booking->setPeopleNumber(4);
        $booking->setPhoneBooking("0678970912");
        $booking->setComments("Ceci est un test de l'entité booking");

        // Get the validator service
        /** @var ValidatorInterface $validator */
        $validator = $container->get(ValidatorInterface::class);

        // Validate the booking entity
        $errors = $validator->validate($booking);

        // compter le nombre d'erreur
        $this->assertCount(0, $errors);
    }

    public function testEntityInValidName(): void
    {
        // (1) boot the Symfony kernel
        $kernel = self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $booking = new Booking();
        $booking->setBookingConfirmed(true);
        $booking->setHourBooking(new \DateTime('now'));
        $booking->setDateBooking(new \DateTime('now'));
        $booking->setNameBooking("");
        $booking->setDiner(True);
        $booking->setEmailBooking("testEmail@testemail.com");
        $booking->setPeopleNumber(4);
        $booking->setPhoneBooking("0678970912");
        $booking->setComments("Ceci est un test de l'entité booking");

        // Get the validator service
        /** @var ValidatorInterface $validator */
        $validator = $container->get(ValidatorInterface::class);

        // Validate the booking entity
        $errors = $validator->validate($booking);

        // compter le nombre d'erreur
        $this->assertCount(1, $errors);
    }
}
