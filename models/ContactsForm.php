<?php

class ContactsForm
{
    private ?int $id = null;
    private DateTime $created_at;
    private ? DateTime $answered_at = null;
    private bool $status = false;


    public function __construct(private string $first_name, private string $last_name, private Email $email_id, private string $phone, private string $inquiry_type, private ?string $how_found, private ?string $message)
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

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
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

    public function getInquiryType(): string
    {
        return $this->inquiry_type;
    }

    public function setInquiryType(string $inquiry_type): void
    {
        $this->inquiry_type = $inquiry_type;
    }

    public function getHowFound(): ?string
    {
        return $this->how_found;
    }

    public function setHowFound(?string $how_found): void
    {
        $this->how_found = $how_found;
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