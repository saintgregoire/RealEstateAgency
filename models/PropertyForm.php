<?php

class PropertyForm
{
    private ?int $id = null;
    private ?DateTime $answered_at = null;
    private bool $status = false;
    private DateTime $created_at;

    public function __construct(private string $fisrt_name, private string $last_name, private Email $emial_id, private string $phone, private Properties $property_id, private ?string $message)
    {
        $this->created_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAnsweredAt(): ?DateTime
    {
        return $this->answered_at;
    }

    public function setAnsweredAt(?DateTime $answered_at): void
    {
        $this->answered_at = $answered_at;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getFisrtName(): string
    {
        return $this->fisrt_name;
    }

    public function setFisrtName(string $fisrt_name): void
    {
        $this->fisrt_name = $fisrt_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getEmialId(): Email
    {
        return $this->emial_id;
    }

    public function setEmialId(Email $emial_id): void
    {
        $this->emial_id = $emial_id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPropertyId(): Properties
    {
        return $this->property_id;
    }

    public function setPropertyId(Properties $property_id): void
    {
        $this->property_id = $property_id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }


}