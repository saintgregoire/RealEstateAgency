<?php

class PropertiesForm
{
    private ?int $id = null;
    private ?DateTime $answered_at = null;
    private bool $status = false;
    private DateTime $created_at;

    public function __construct(private string $first_name, private string $last_name, private Email $email_id, private string $phone, private string $location, private string $property_type, private ?int $no_bathroom, private ?int $no_bedroom, private string $budget, private ?string $message)
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

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getEmailId(): Email
    {
        return $this->email_id;
    }

    public function setEmailId(Email $email_id): void
    {
        $this->email_id = $email_id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getPropertyType(): string
    {
        return $this->property_type;
    }

    public function setPropertyType(string $property_type): void
    {
        $this->property_type = $property_type;
    }

    public function getNoBathroom(): ?int
    {
        return $this->no_bathroom;
    }

    public function setNoBathroom(?int $no_bathroom): void
    {
        $this->no_bathroom = $no_bathroom;
    }

    public function getNoBedroom(): ?int
    {
        return $this->no_bedroom;
    }

    public function setNoBedroom(?int $no_bedroom): void
    {
        $this->no_bedroom = $no_bedroom;
    }

    public function getBudget(): string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): void
    {
        $this->budget = $budget;
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