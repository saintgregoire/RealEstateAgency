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
                $item = new ContactsForm($lead['first_name'], $lead['last_name'], $lead['email'], $lead['phone'], $lead['inquiry_type'], $lead['how_found'], $lead['message']);
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
                $item = new ContactsForm($lead['first_name'], $lead['last_name'], $lead['email'], $lead['phone'], $lead['inquiry_type'], $lead['how_found'], $lead['message']);
                $item->setId($lead['id']);
                $item->setCreatedAt($lead['created_at']);
                $item->setAnsweredAt($lead['answered_at']);
                $item->setStatus($lead['status']);
                $formLeads[] = $item;
            }
            return $formLeads;
            }
        else{
            return null;
        }
    }

}