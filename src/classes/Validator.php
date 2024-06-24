<?php

namespace App\classes;


use Symfony\Component\Validator\Context\ExecutionContextInterface;

class BookingValidator
{
    public static function validateBookingHour($hour, ExecutionContextInterface $context, $payload)
    {
        $morningStart = new \DateTime('12:00');
        $morningEnd = new \DateTime('14:00');
        $eveningStart = new \DateTime('19:00');
        $eveningEnd = new \DateTime('21:00');

        // Extraire uniquement les heures et les minutes pour la comparaison
        $hourTime = \DateTime::createFromFormat('H:i', $hour->format('H:i'));

        if (($hourTime >= $morningStart && $hourTime <= $morningEnd) || ($hourTime >= $eveningStart && $hourTime <= $eveningEnd)) {
            return;
        }

        $context->buildViolation('Les horaires de réservation doivent être compris entre 12h et 14h ou entre 19h et 21h.')
            ->atPath('hour_booking')
            ->addViolation();
    }
}
