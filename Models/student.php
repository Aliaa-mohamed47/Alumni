<?php
    require_once '../../Controlers/DBControler.php';
    require_once '../../Models/UserFactory.php';

    class Student
    {
        public $id;
        public $name;
        public $email;
        public $password;
        public $sex;
        public $level;

        public function login($email, $password) 
        {
            $db = new DBControler();
            if ($db->openConnection()) 
            {
                $query = "select * from students where email = '$email' and password = '$password'";
                $result = $db->select($query);
                if ($result && count($result) > 0) 
                {
                    $_SESSION["userId"] = $result[0]["id"];
                    $_SESSION["userName"] = $result[0]["name"];
                    $_SESSION["userRole"] = "student";
                    return true;
                }
            }
            return false;
        }

        public function __construct($id = null, $name = null, $email = null, $password = null, $sex = null, $level = null) 
        {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->sex = $sex;
            $this->level = $level;
        }

        public function getId() 
        {
            return $this->id;
        }

        public function getName() 
        {
            return $this->name;
        }

        public function getEmail() 
        {
            return $this->email;
        }

        public function getPassword() 
        {
            return $this->password;
        }

        public function getSex() 
        {
            return $this->sex;
        }

        public function getLevel() 
        {
            return $this->level;
        }
        

}

?>