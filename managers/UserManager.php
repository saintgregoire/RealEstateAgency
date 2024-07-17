<?php

class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array
    {
        $query = $this->db->prepare("SELECT * FROM admins");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($result as $row) {
            $user = new User(
                $row['email'],
                $row['password'],
                $row['role']
            );
            $user->setId($row['id']);
            $users[] = $user;
        }
        return $users;
    }



    public function findByEmail(string $email) : ? User
    {
        $query = $this->db->prepare("SELECT * FROM admins WHERE email = :email");
        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            $user = new User(
                $result['email'],
                $result['password'],
                $result['role']
            );
            $user->setId($result['id']);
            return $user;
        }
        else{
            return null;
        }

    }

    public function addOneUser( string $email, string $password, string $role) : void{
        $query = $this->db->prepare("
        INSERT INTO admins (email, password, role)
        VALUES (:email, :password, :role)");
        $parameters = [
            "email" => $email,
            "password" => $password,
            "role" => $role
        ];
        $query->execute($parameters);
    }


    public function deleteOneUser(int $id) : void
    {
        $query = $this->db->prepare("DELETE FROM admins WHERE id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
    }

    public function changeRole(int $id, string $role) : void
    {
      $query = $this->db->prepare("UPDATE admins SET role = :role WHERE id = :id");
      $parameters = [
          "id" => $id,
          "role" => $role
      ];
      $query->execute($parameters);
    }

    public function changePassword(int $id, string $password) : void
    {
        $query = $this->db->prepare("UPDATE admins SET password = :password WHERE id = :id");
        $parameters = [
            "id" => $id,
            "password" => $password
        ];
        $query->execute($parameters);
    }

    public function changeEmail(int $id, string $email) : void
    {
        $query = $this->db->prepare("UPDATE admins SET email = :email WHERE id = :id");
        $parameters = [
            "id" => $id,
            "email" => $email
        ];
        $query->execute($parameters);
    }

}