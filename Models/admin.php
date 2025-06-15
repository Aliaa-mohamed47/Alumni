<?php
    require_once '../../Controlers/DBControler.php';
    require_once '../../Models/UserFactory.php';

    class Admin
    {
        public $id;
        public $name;
        public $email;
        public $password;
        public $phone;

        public function login($email, $password) 
        {
            $db = new DBControler();
            if ($db->openConnection()) 
            {
                $query = "select * from admins where email = '$email' and password = '$password'";
                $result = $db->select($query);
                if ($result && count($result) > 0)
                    {
                        $_SESSION["userId"] = $result[0]["id"];
                        $_SESSION["userName"] = $result[0]["name"];
                        $_SESSION["userRole"] = "admin";
                        $_SESSION["admin_id"] = $result[0]["id"];

                        return true;
                    }
            }
            return false;
        }
 
        public function __construct($id = null, $name = null, $email = null, $password = null, $phone = null) 
        {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->phone = $phone;
        }

        public function getId() 
        {
            return $this->id;
        }


        public function getAllAdmins()
        {
            $db = new DBControler();
            if ($db->openConnection()) {
                $query = "SELECT id, name FROM admins";
                $result = $db->select($query);
                $db->closeConnection();
                return $result;
            }
            return [];
        }
        
    }
    


?>