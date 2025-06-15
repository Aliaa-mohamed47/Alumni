<?php
    require_once '../../Controlers/DBControler.php';
    require_once '../../Models/UserFactory.php';

    class Alumni
    {
        public $id;
        public $name;
        public $email;
        public $password;
        public $sex;
        public $graduation_year;
        public $rating;
        public $department;
        public $job_title;

        public function login($email, $password) 
        {
            $db = new DBControler();
            if ($db->openConnection()) 
            {
                $query = "select * from alumnis where email = '$email' and password = '$password'";
                $result = $db->select($query);
                if ($result && count($result) > 0) 
                {
                    $_SESSION["userId"] = $result[0]["id"];
                    $_SESSION["userName"] = $result[0]["name"];
                    $_SESSION["userRole"] = "alumni";
                    return true;
                }
            }
            return false;
        }

        public function __construct($id = null, $name = null, $email = null, $password = null, $sex = null, $graduation_year = null, $rating = null, $department = null, $job_title = null) 
        {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->sex = $sex;
            $this->graduation_year = $graduation_year;
            $this->rating = $rating;
            $this->department = $department;
            $this->job_title = $job_title;
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

        public function getGraduationYear()
        {
            return $this->graduation_year;
        }
        

        public function getRating()
        {
            return $this->rating;
        }

        public function getDepartment()
        {
            return $this->department;
        }

        public function getJobTitle()
        {
            return $this->job_title;
        }

    }

?>