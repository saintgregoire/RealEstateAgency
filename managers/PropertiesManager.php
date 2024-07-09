<?php

class PropertiesManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare("
        SELECT *
        FROM properties
        ");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $properties = [];
            foreach ($result as $property){
                $properties[] = new Properties(
                    $property['name'],
                    $property['description_for_card'],
                    $property['location'],
                    $property['no_bathrooms'],
                    $property['no_bathrooms'],
                    $property['type'],
                    $property['sq_feet'],
                    $property['listing_price'],
                    $property['transfer_tax'],
                    $property['legal_fees'],
                    $property['home_inspection'],
                    $property['insurance'],
                    $property['mortg_fees'],
                    $property['property_tax'],
                    $property['assos_fee'],
                    $property['addit_fee'],
                    $property['down_payment'],
                    $property['mortg_amount'],
                    $property['mortg_pay'],
                    $property['prop_insurance_month']
                );
            }
            return $properties;
    }

    public function findByName(string $name) : ? Properties
    {
        $query = $this->db->prepare("
        SELECT *
        FROM properties
        WHERE name = :name
        ");
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result){
            $property = new Properties(
                $result['name'],
                $result['description_for_card'],
                $result['location'],
                $result['no_bathrooms'],
                $result['no_bathrooms'],
                $result['type'],
                $result['sq_feet'],
                $result['listing_price'],
                $result['transfer_tax'],
                $result['legal_fees'],
                $result['home_inspection'],
                $result['insurance'],
                $result['mortg_fees'],
                $result['property_tax'],
                $result['assos_fee'],
                $result['addit_fee'],
                $result['down_payment'],
                $result['mortg_amount'],
                $result['mortg_pay'],
                $result['prop_insurance_month']
            );
            return $property;
        }
        else{
            return null;
        }
    }



}