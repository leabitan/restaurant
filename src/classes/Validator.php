<?php

namespace App\classes;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
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
class PasswordComplexity extends Constraint
{
    public $message = 'Le mot de passe doit contenir au moins 10 caractères, dont une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.';
}

class PasswordComplexityValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\PasswordComplexity */

        if (null === $value || '' === $value) {
            return;
        }

        // Regex pour vérifier les critères de complexité du mot de passe
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{10,}$/', $value, $matches)) {
            // le mot de passe ne répond pas aux exigences de complexité
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
