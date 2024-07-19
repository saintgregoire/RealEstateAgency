<?php

class EmailManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findOneEmail(string $email) : ?Email {
        $query = $this->db->prepare("SELECT * FROM emails WHERE email = :email");
        $parameters = [
            'email' => $email
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            $newEmail = new Email($result['email']);
            $newEmail->setId($result['id']);
            return $newEmail;
        }
        else{
            return null;
        }

    }

    public function addEmail(string $email) : void{
        if($this->findOneEmail($email) === null){
            $query = $this->db->prepare("INSERT INTO emails (email) VALUES (:email)");
            $parameters = [
                'email' => $email
            ];
            $query->execute($parameters);
        }
    }

    public function findById(int $id) : ? Email
    {
       $query = $this->db->prepare("SELECT * FROM emails WHERE id = :id");
       $parameters = [
           'id' => $id
       ];
       $query->execute($parameters);
       $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            $newEmail = new Email($result['email']);
            return $newEmail;
        }
        else{
            return null;
        }
    }

    public function getAllEmailsAsTxt() : ? string
    {
        $query = $this->db->prepare("SELECT * FROM emails");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if($result){
            $temp_file = tempnam(sys_get_temp_dir(), 'txt');
            $file = fopen($temp_file, 'w');

            foreach ($result as $row) {
                fputcsv($file, $row, "\t");
            }

            fclose($file);
            return $temp_file;
        }
        else{
            return null;
        }

    }



}