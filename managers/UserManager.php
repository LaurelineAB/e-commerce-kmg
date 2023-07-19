<?php

class UserManager extends AbstractManager
{
    //private PDO $db;


    // création de user
    public function insertUser(User $user) : ?User
    {
        $query = $this->db->prepare("INSERT INTO users(first_name,last_name, email, password) VALUES (:firstName,:lastName, :email, :password)");
        $parameters = [
            "firstName" => $user->getFirstName(),
            "lastName" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword()
        ];

        $query->execute($parameters);
        // $id = $query->fetch(PDO::FETCH_ASSOC);
        $user->setId($this->db->lastInsertId());
        return $user;

    }

    //Mise à jour d'un User

    public function updateUser(User $user) : void
    {
        $query = $this->db->prepare("UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email, password = :password WHERE users.id = :id");
        $parameters = [
            "firstName" => $user->getFirstName(),
            "lastName" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword
        ];
        $query->execute($parameters);
    }



    // supression d'un user
    public function deleteUser(User $user) : void
    {
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $parameters = [
            "id" => $user->getId()
        ];
        $query->execute($parameters);

    }

    //reccuperation d'un user avec id
    public function getUserById(int $id) : ?User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result !== false)
        {
            $user = new User($result["first_name"],$result["last_name"], $result["email"], $result["password"]);
            $user->setId($result["id"]);
            return $user;
        }
        else
        {
            return null;
        }
    }

    // reccuperation de tous les utilisateurs
    public function getAllUsers() : array
    {
        $list = [];
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if($result !== false)
        {
            foreach($result as $item)
            {
                $user = new User($item['first_name'], $item['last_name'], $item['email'], $item['password']);
                $user->setId($item['id']);
                $list[] = $user;
            }
        }
        return $list;
    }
}

?>