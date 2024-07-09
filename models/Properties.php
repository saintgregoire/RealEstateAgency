<?php

class Properties
{
    private ?int $id = null;
    public function __construct(private string $name,
                                private string $description_for_card,
                                private string $location,
                                private int $no_bedrooms,
                                private int $no_bathrooms,
                                private string $type,
                                private string $sq_feet,
                                private string $listing_price,
                                private string $transfer_tax,
                                private string $legal_fees,
                                private string $home_inspection,
                                private string $insurance,
                                private string $mortg_fees,
                                private string $property_tax,
                                private string $assos_fee,
                                private string $addit_fee,
                                private string $down_payment,
                                private string $mortg_amount,
                                private string $mortg_pay,
                                private string $prop_insurance_month)
    {

    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescriptionForCard(): string
    {
        return $this->description_for_card;
    }

    public function setDescriptionForCard(string $description_for_card): void
    {
        $this->description_for_card = $description_for_card;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getNoBedrooms(): int
    {
        return $this->no_bedrooms;
    }

    public function setNoBedrooms(int $no_bedrooms): void
    {
        $this->no_bedrooms = $no_bedrooms;
    }

    public function getNoBathrooms(): int
    {
        return $this->no_bathrooms;
    }

    public function setNoBathrooms(int $no_bathrooms): void
    {
        $this->no_bathrooms = $no_bathrooms;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getSqFeet(): string
    {
        return $this->sq_feet;
    }

    public function setSqFeet(string $sq_feet): void
    {
        $this->sq_feet = $sq_feet;
    }

    public function getListingPrice(): string
    {
        return $this->listing_price;
    }

    public function setListingPrice(string $listing_price): void
    {
        $this->listing_price = $listing_price;
    }

    public function getTransferTax(): string
    {
        return $this->transfer_tax;
    }

    public function setTransferTax(string $transfer_tax): void
    {
        $this->transfer_tax = $transfer_tax;
    }

    public function getLegalFees(): string
    {
        return $this->legal_fees;
    }

    public function setLegalFees(string $legal_fees): void
    {
        $this->legal_fees = $legal_fees;
    }

    public function getHomeInspection(): string
    {
        return $this->home_inspection;
    }

    public function setHomeInspection(string $home_inspection): void
    {
        $this->home_inspection = $home_inspection;
    }

    public function getInsurance(): string
    {
        return $this->insurance;
    }

    public function setInsurance(string $insurance): void
    {
        $this->insurance = $insurance;
    }

    public function getMortgFees(): string
    {
        return $this->mortg_fees;
    }

    public function setMortgFees(string $mortg_fees): void
    {
        $this->mortg_fees = $mortg_fees;
    }

    public function getPropertyTax(): string
    {
        return $this->property_tax;
    }

    public function setPropertyTax(string $property_tax): void
    {
        $this->property_tax = $property_tax;
    }

    public function getAssosFee(): string
    {
        return $this->assos_fee;
    }

    public function setAssosFee(string $assos_fee): void
    {
        $this->assos_fee = $assos_fee;
    }

    public function getAdditFee(): string
    {
        return $this->addit_fee;
    }

    public function setAdditFee(string $addit_fee): void
    {
        $this->addit_fee = $addit_fee;
    }

    public function getDownPayment(): string
    {
        return $this->down_payment;
    }

    public function setDownPayment(string $down_payment): void
    {
        $this->down_payment = $down_payment;
    }

    public function getMortgAmount(): string
    {
        return $this->mortg_amount;
    }

    public function setMortgAmount(string $mortg_amount): void
    {
        $this->mortg_amount = $mortg_amount;
    }

    public function getMortgPay(): string
    {
        return $this->mortg_pay;
    }

    public function setMortgPay(string $mortg_pay): void
    {
        $this->mortg_pay = $mortg_pay;
    }

    public function getPropInsuranceMonth(): string
    {
        return $this->prop_insurance_month;
    }

    public function setPropInsuranceMonth(string $prop_insurance_month): void
    {
        $this->prop_insurance_month = $prop_insurance_month;
    }



}