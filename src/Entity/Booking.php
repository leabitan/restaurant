<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_booking = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?int $peopleNumber = null;

    #[ORM\Column(nullable: true)]
    private ?bool $bookingConfirmed = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hour_booking = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $name_booking = null;

    #[ORM\Column(length: 20)]
    private ?string $phone_booking = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\Email(
        message: 'Email {{ value }} non valide.',
    )]
    private ?string $email_booking = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comments = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $diner = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBooking(): ?\DateTimeInterface
    {
        return $this->date_booking;
    }

    public function setDateBooking(\DateTimeInterface $date_booking): static
    {
        $this->date_booking = $date_booking;

        return $this;
    }

    public function getPeopleNumber(): ?int
    {
        return $this->peopleNumber;
    }

    public function setPeopleNumber(int $peopleNumber): static
    {
        $this->peopleNumber = $peopleNumber;

        return $this;
    }

    public function isBookingConfirmed(): ?bool
    {
        return $this->bookingConfirmed;
    }

    public function setBookingConfirmed(bool $bookingConfirmed): static
    {
        $this->bookingConfirmed = $bookingConfirmed;

        return $this;
    }

    public function getHourBooking(): ?\DateTimeInterface
    {
        return $this->hour_booking;
    }

    public function setHourBooking(\DateTimeInterface $hour_booking): static
    {
        $this->hour_booking = $hour_booking;

        return $this;
    }

    public function getNameBooking(): ?string
    {
        return $this->name_booking;
    }

    public function setNameBooking(string $name_booking): static
    {
        $this->name_booking = $name_booking;

        return $this;
    }

    public function getPhoneBooking(): ?string
    {
        return $this->phone_booking;
    }

    public function setPhoneBooking(string $phone_booking): static
    {
        $this->phone_booking = $phone_booking;

        return $this;
    }

    public function getEmailBooking(): ?string
    {
        return $this->email_booking;
    }

    public function setEmailBooking(string $email_booking): static
    {
        $this->email_booking = $email_booking;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function isDiner(): ?bool
    {
        return $this->diner;
    }

    public function setDiner(bool $diner): static
    {
        $this->diner = $diner;

        return $this;
    }
}
