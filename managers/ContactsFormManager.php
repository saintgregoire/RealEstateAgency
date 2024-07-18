<?php

class ContactsFormManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM contacts_form");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $formLeads = [];
            foreach ($result as $lead){
                $item = new ContactsForm($lead['first_name'], $lead['last_name'], $lead['email_id'], $lead['phone'], $lead['inquiry_type'], $lead['how_found'], $lead['message']);
                $item->setId($lead['id']);
                $item->setCreatedAt($lead['created_at']);
                $item->setAnsweredAt($lead['answered_at']);
                $item->setStatus($lead['status']);
                $formLeads[] = $item;
            }
        return $formLeads;
    }

    public function findNotAnswered(): ? array
    {
        $query = $this->db->prepare("SELECT * FROM contacts_form WHERE status = :status");
        $parameters = [
            "status" => false
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $formLeads = [];
        if($result){
            foreach ($result as $lead){
                $createdAt = new DateTime($lead['created_at']);
                if($lead['answered_at']){
                    $answeredAt = new DateTime($lead['answered_at']);

                }
                else{
                    $answeredAt = null;
                }

                $item = new ContactsForm($lead['first_name'], $lead['last_name'], $lead['email_id'], $lead['phone'], $lead['inquiry_type'], $lead['how_found'], $lead['message']);
                $item->setId($lead['id']);
                $item->setCreatedAt($createdAt);
                $item->setAnsweredAt($answeredAt);
                $item->setStatus($lead['status']);
                $formLeads[] = $item;
            }
            return $formLeads;
            }
        else{
            return null;
        }
    }

    public function addOne(ContactsForm $contact) : void
    {
        $query = $this->db->prepare("
        INSERT INTO contacts_form (
                first_name,
                last_name,
                email_id,
                phone,
                inquiry_type,
                how_found,
                message,
                created_at,
                answered_at,
                status
        )
        VALUES (
                :first_name,
                :last_name,
                :email_id,
                :phone,
                :inquiry_type,
                :how_found,
                :message,
                :created_at,
                :answered_at,
                :status
        )
        ");
        $parameters = [
            ":first_name" => $contact->getFirstName(),
            ":last_name" => $contact->getLastName(),
            ":email_id" => $contact->getEmailId(),
            ":phone" => $contact->getPhone(),
            ":inquiry_type" => $contact->getInquiryType(),
            ":how_found" => $contact->getHowFound(),
            ":message" => $contact->getMessage(),
            ":created_at" => $contact->getCreatedAt(),
            ":answered_at" => $contact->getAnsweredAt(),
            ":status" => $contact->isStatus()
        ];
        $query->execute($parameters);
    }

    public function changeStatusToDone(int $id ) : void
    {
     $query = $this->db->prepare("UPDATE contacts_form SET status = :status WHERE id = :id");
     $parameters = [
         ":status" => true,
         ":id" => $id
     ];
     $query->execute($parameters);
    }

}