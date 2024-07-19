<?php

class PropertyFormManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addOne(PropertyForm $lead) : void
    {
        $query = $this->db->prepare("
        INSERT INTO property_form(
             first_name, last_name, email_id, phone, property_id, message, created_at, answered_at, status
        ) VALUES (
            :first_name,
            :last_name,
            :email_id,
            :phone,
            :property_id,
            :message,
            :created_at,
            :answered_at,
            :status
        )
        ");
        $parameters = [
            "first_name" => $lead->getFirstName(),
            "last_name" => $lead->getLastName(),
            "email_id" => $lead->getEmailId(),
            "phone" => $lead->getPhone(),
            "property_id" => $lead->getPropertyId(),
            "message" => $lead->getMessage(),
            "created_at" => $lead->getCreatedAt(),
            "answered_at" => $lead->getAnsweredAt(),
            "status" => $lead->isStatus()
        ];
        $query->execute($parameters);
    }


    public function findAll() : array
    {
        $query = $this->db->prepare("
        SELECT * FROM property_form
        ");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $formLeads = [];
        foreach($result as $lead){
            $item = new PropertyForm(
                $lead["first_name"],
                $lead["last_name"],
                $lead["email_id"],
                $lead["phone"],
                $lead["property_id"],
                $lead["message"]
            );
            $item->setId($lead["id"]);
            $item->setAnsweredAt($lead["answered_at"]);
            $item->setCreatedAt($lead["created_at"]);
            $item->setStatus($lead["status"]);
            $formLeads[] = $item;
        }
        return $formLeads;
    }

    public function findNotAnswered() : ?array{
        $query = $this->db->prepare("SELECT * FROM property_form WHERE status = :status");
        $parameters = [
            "status" => false
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $formLeads = [];
        if($result){
            foreach($result as $lead){
                $createdAt = new DateTime($lead["created_at"]);
                if($lead["answered_at"]){
                    $answeredAt = new DateTime($lead["answered_at"]);
                }
                else{
                    $answeredAt = null;
                }
                $item = new PropertyForm(
                    $lead["first_name"],
                    $lead["last_name"],
                    $lead["email_id"],
                    $lead["phone"],
                    $lead["property_id"],
                    $lead["message"]
                );
                $item->setId($lead["id"]);
                $item->setAnsweredAt($answeredAt);
                $item->setCreatedAt($createdAt);
                $item->setStatus($lead["status"]);
                $formLeads[] = $item;
            }
            return $formLeads;
        }
        else{
            return null;
        }
    }

    public function changeStatusToDone(int $id) : void{
        $query = $this->db->prepare("UPDATE property_form SET status = :status WHERE id = :id");
        $parameters = [
            ":status" => true,
            ":id" => $id
        ];
        $query->execute($parameters);
    }
}