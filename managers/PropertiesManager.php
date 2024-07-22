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
                $item = new Properties(
                    $property['name'],
                    $property['description_for_card'],
                    $property['location'],
                    $property['no_bedrooms'],
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
                $item->setId($property['id']);
                $properties[] = $item;
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
                $result['no_bedrooms'],
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
            $property->setId($result['id']);
            return $property;
        }
        else{
            return null;
        }
    }

    public function addOne(string $name,
                           string $description_for_card,
                           string $location,
                           int $no_bedrooms,
                           int $no_bathrooms,
                            string $type,
                            string $sq_feet,
                            string $listing_price,
                            string $transfer_tax,
                            string $legal_fees,
                            string $home_inspection,
                            string $insurance,
                            string $mortg_fees,
                            string $property_tax,
                            string $assos_fee,
                            string $addit_fee,
                            string $down_payment,
                            string $mortg_amount,
                            string $mortg_pay,
                            string $prop_insurance_month

    ) : void
    {
        $query = $this->db->prepare("
        INSERT INTO properties(name, description_for_card, location, no_bedrooms, no_bathrooms, type, sq_feet, listing_price, transfer_tax, legal_fees, home_inspection, insurance, mortg_fees, property_tax, assos_fee, addit_fee, down_payment, mortg_amount, mortg_pay, prop_insurance_month)
        VALUES (:name, :description_for_card, :location, :no_bedrooms, :no_bathrooms, :type, :sq_feet, :listing_price, :transfer_tax, :legal_fees, :home_inspection, :insurance, :mortg_fees, :property_tax, :assos_fee, :addit_fee, :down_payment, :mortg_amount, :mortg_pay, :prop_insurance_month)
        ");
        $parameters = [
            'name' => $name,
            'description_for_card' => $description_for_card,
            'location' => $location,
            'no_bedrooms' => $no_bedrooms,
            'no_bathrooms' => $no_bathrooms,
            'type' => $type,
            'sq_feet' => $sq_feet,
            'listing_price' => $listing_price,
            'transfer_tax' => $transfer_tax,
            'legal_fees' => $legal_fees,
            'home_inspection' => $home_inspection,
            'insurance' => $insurance,
            'mortg_fees' => $mortg_fees,
            'property_tax' => $property_tax,
            'assos_fee' => $assos_fee,
            'addit_fee' => $addit_fee,
            'down_payment' => $down_payment,
            'mortg_amount' => $mortg_amount,
            'mortg_pay' => $mortg_pay,
            'prop_insurance_month' => $prop_insurance_month
        ];
        $query->execute($parameters);
    }

    public function findById(int $id) : ?Properties
    {
        $query = $this->db->prepare("
        SELECT *
        FROM properties
        WHERE id = :id
        ");
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result){
            $property = new Properties(
                $result['name'],
                $result['description_for_card'],
                $result['location'],
                $result['no_bedrooms'],
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


    public  function deleteOne(int $id) : void
    {
        $query = $this->db->prepare("
        DELETE FROM properties WHERE id = :id
        ");
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
    }


    public function modifyOne(int $id, string $description, string $location, int $no_bedrooms, int $no_bathrooms, string $type, string $sq_feet, string $listing_price, string $transfer_tax, string $legal_fees, string $inspection, string $insurance, string $mortg_fees, string $property_tax, string $assos_fee, string $addit_fee, string $down_payment, string $mortg_amount, string $mort_pay, string $insuranse_month) : void
    {
        $query = $this->db->prepare("UPDATE properties 
        SET description_for_card = :description_for_card,
            location = :location,
            no_bedrooms = :no_bedrooms,
            no_bathrooms = :no_bathrooms,
            type = :type,
            sq_feet = :sq_feet,
            listing_price = :listing_price,
            transfer_tax = :transfer_tax,
            legal_fees = :legal_fees,
            home_inspection = :home_inspection,
            insurance = :insurance,
            mortg_fees = :mortg_fees,
            property_tax = :property_tax,
            assos_fee = :assos_fee,
            addit_fee = :addit_fee,
            down_payment = :down_payment,
            mortg_amount = :mortg_amount,
            mortg_pay = :mortg_pay,
            prop_insurance_month = :prop_insurance_month
        WHERE id = :id
            ");
        $parameters = [
            'description_for_card' => $description,
            'location' => $location,
            'no_bedrooms' => $no_bedrooms,
            'no_bathrooms' => $no_bathrooms,
            'type' => $type,
            'sq_feet' => $sq_feet,
            'listing_price' => $listing_price,
            'transfer_tax' => $transfer_tax,
            'legal_fees' => $legal_fees,
            'home_inspection' => $inspection,
            'insurance' => $insurance,
            'mortg_fees' => $mortg_fees,
            'property_tax' => $property_tax,
            'assos_fee' => $assos_fee,
            'addit_fee' => $addit_fee,
            'down_payment' => $down_payment,
            'mortg_amount' => $mortg_amount,
            'mortg_pay' => $mort_pay,
            'prop_insurance_month' => $insuranse_month,
            'id' => $id
        ];
        $query->execute($parameters);
    }


}