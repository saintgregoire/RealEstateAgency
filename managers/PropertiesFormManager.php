<?php

class PropertiesFormManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addOne(PropertiesForm $lead) : void{
        $query = $this->db->prepare("
            INSERT INTO properties_form(
                first_name, last_name, email_id, phone, location, property_type, no_bathroom, no_bedroom, budget, message, created_at, answered_at, status
            )
            VALUES (
                :first_name,
                :last_name,
                :email_id,
                :phone,
                :location,
                :property_type,
                :no_bathroom,
                :no_bedroom,
                :budget,
                :message,
                :created_at,
                :answered_at,
                :status
            )
        ");
        $parameters = [
            ":first_name" => $lead->getFirstName(),
            ":last_name" => $lead->getLastName(),
            ":email_id" => $lead->getEmailId(),
            ":phone" => $lead->getPhone(),
            ":location" => $lead->getLocation(),
            ":property_type" => $lead->getPropertyType(),
            ":no_bathroom" => $lead->getNoBathroom(),
            ":no_bedroom" => $lead->getNoBedroom(),
            ":budget" => $lead->getBudget(),
            ":message" => $lead->getMessage(),
            ":created_at" => $lead->getCreatedAt(),
            ":answered_at" => $lead->getAnsweredAt(),
            ":status" => $lead->isStatus()
        ];
        $query->execute($parameters);
    }

    public function findNotAnswered() : ? array
    {
      $query = $this->db->prepare("
      SELECT * FROM properties_form WHERE status = :status
      ");
      $parameters = [
          ":status" => false
      ];
      $query->execute($parameters);
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      $formLeads = [];
      if($result){
          foreach($result as $lead){
              $createdAt = new DateTime($lead['created_at']);
              if($lead['answered_at']){
                  $answeredAt = new DateTime($lead['answered_at']);

              }
              else{
                  $answeredAt = null;
              }

              $item = new PropertiesForm(
                  $lead["first_name"],
                  $lead["last_name"],
                  $lead["email_id"],
                  $lead["phone"],
                  $lead["location"],
                  $lead["property_type"],
                  $lead["no_bathroom"],
                  $lead["no_bedroom"],
                  $lead["budget"],
                  $lead["message"]
              );
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

    public function changeStatusToDone(int $id) : void{
        $query = $this->db->prepare("UPDATE properties_form SET status = :status WHERE id = :id");
        $parameters = [
            ":status" => true,
            ":id" => $id
        ];
        $query->execute($parameters);
    }

}