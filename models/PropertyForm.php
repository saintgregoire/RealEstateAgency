<?php

class PropertyForm
{
    private ?int $id = null;
    private ?DateTime $answered_at = null;
    private bool $status = false;
    private DateTime $created_at;

    public function __construct(private string $first_name, private string $last_name, private int $email_id, private string $phone, private ? int $property_id, private ?string $message)
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

    public function getAnsweredAt(): ?string
    {
        if ($this->answered_at !== null) {
            return $this->answered_at->format('Y-m-d H:i:s');
        }
        else{
            return null;
        }
    }

    public function setAnsweredAt(?DateTime $answered_at): void
    {
        if($answered_at !== null){
            $answered_at->format('Y-m-d H:i:s');
        }
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

    public function getCreatedAt(): string
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $created_at->format('Y-m-d H:i:s');
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

    public function getEmailId(): int
    {
        return $this->email_id;
    }

    public function setEmailId(int $email_id): void
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

    public function getPropertyId(): ? int
    {
        return $this->property_id;
    }

    public function setPropertyId( ? int $property_id): void
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