<?php

namespace AssurConnect\Api\Resources\Request\Besafe\Entities;

class SubscriberEntity
{
    protected $lastname;
    protected $firstname;
    protected $salutation = 'Mr';
    protected $address;
    protected $additionalAddress = '';
    protected $zipCode;
    protected $city;
    protected $country = 'FR';
    protected $birthDate;
    protected $email;
    protected $phone;

    public function prepare(): array
    {
        return [
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'civility' => $this->salutation,
            'address' => $this->address,
            'additional_address' => $this->additionalAddress,
            'postal_code' => $this->zipCode,
            'city' => $this->city,
            'country' => $this->country,
            'date_of_birth' => $this->birthDate,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setSalutation(string $salutation): void
    {
        $this->salutation = $salutation;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setAdditionalAddress(string $additionalAddress): void
    {
        $this->additionalAddress = $additionalAddress;
    }

    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function setBirthdate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getBirthdate(): string
    {
        return $this->birthDate;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}
