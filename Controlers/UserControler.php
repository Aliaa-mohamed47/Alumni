<?php
require_once '../../Controlers/DBControler.php';

class UserControler
{
    protected $db;

    public function __construct()
    {
        $this->db = new DBControler;
        $this->db->openConnection();
    }

    public function getUserProfile($userId, $userRole)
    {
        if ($userRole === 'alumni') {
            $qry = "SELECT * FROM alumnis WHERE id = $userId";
        } else {
            $qry = "SELECT * FROM students WHERE id = $userId";
        }
        
        $result = $this->db->getConnection()->query($qry);
        return $result->fetch_assoc();
    }

    public function updateUserProfile($userId, $fullName, $email, $department, $jobTitle, $userRole, $level = null)
    {
        if ($userRole === 'alumni') {
            $qry = "UPDATE alumnis SET name = '$fullName', email = '$email', department = '$department', job_title = '$jobTitle' WHERE id = $userId";
        } else {
            $qry = "UPDATE students SET name = '$fullName', email = '$email', level = '$level' WHERE id = $userId";
        }

        return $this->db->getConnection()->query($qry);
    }


    public function __destruct()
    {
        $this->db->closeConnection();
    }

    public function registerStudentForEvent($studentId, $eventId)
    {
        $exists = $this->db->select("SELECT * FROM event_attendance WHERE studentId = ? AND eventId = ?", [$studentId, $eventId]);
        if (empty($exists)) 
        {
            $query = "INSERT INTO event_attendance (studentId, eventId, attended) VALUES (?, ?, ?)";
            return $this->db->insert($query, [$studentId, $eventId, 'pending']); // وضع الحالة كـ 'pending'
        }
        return false;
    }

    public function registerAlumniAsSpeaker($alumniId, $eventId)
    {
        $exists = $this->db->select("SELECT * FROM event_speakers WHERE alumniId = ? AND eventId = ?", [$alumniId, $eventId]);
        if (empty($exists)) {
            $query = "INSERT INTO event_speakers (alumniId, eventId, speaker_status) VALUES (?, ?, ?)";
            return $this->db->insert($query, [$alumniId, $eventId, 'pending']); // وضع الحالة كـ 'pending'
        }
        return false;
    }

    function isEmailExists($email, $db) 
    {
        $result = $db->selectt(
            "SELECT id FROM admins WHERE email = ? 
            UNION 
            SELECT id FROM alumnis WHERE email = ? 
            UNION 
            SELECT id FROM students WHERE email = ?", 
            [$email, $email, $email]
        );

        if ($result && $result->num_rows > 0) {
            return true;
        }

        return false;
    }

    function isValidPassword($password) 
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[\W]/', $password);
    }


    public function addAlumni($name, $email, $password, $sex, $graduation_year, $department, $job_title, $phone, $company) 
    {
        if ($this->isEmailExists($email, $this->db)) {
            $_SESSION["errMsg"] = "Email already exists!";
            return false;
        }

        if (!$this->db->openConnection()) {
            $_SESSION["errMsg"] = "Database connection error.";
            return false;
        }

        $conn = $this->db->getConnection();

        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
        $sex = $conn->real_escape_string($sex);
        $graduation_year = $conn->real_escape_string($graduation_year);
        $department = $conn->real_escape_string($department);
        $job_title = $conn->real_escape_string($job_title);
        $phone = $conn->real_escape_string($phone);
        $company = $conn->real_escape_string($company);

        $sql = "INSERT INTO alumnis (name, email, password, sex, graduation_year, department, job_title, phone, company)
                VALUES ('$name', '$email', '$password', '$sex', '$graduation_year', '$department', '$job_title', '$phone', '$company')";

        if ($conn->query($sql)) {
            return true;
        } else {
            $_SESSION["errMsg"] = "Database error: " . $conn->error;
            return false;
        }
    }


    public function addStudent($name, $email, $password, $sex, $level, $department) 
    {
        if ($this->isEmailExists($email, $this->db)) {
            $_SESSION["errMsg"] = "Email already exists!";
            return false;
        }

        if (!$this->db->openConnection()) {
            $_SESSION["errMsg"] = "Database connection error.";
            return false;
        }

        $conn = $this->db->getConnection();

        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
        $sex = $conn->real_escape_string($sex);
        $level = $conn->real_escape_string($level);
        $department = $conn->real_escape_string($department);

        $sql = "INSERT INTO students (name, email, password, sex, level, department)
                VALUES ('$name', '$email', '$password', '$sex', '$level', '$department')";

        if ($conn->query($sql)) {
            return true;
        } else {
            $_SESSION["errMsg"] = "Database error: " . $conn->error;
            return false;
        }
    }


    public function addAdmin($name, $email, $password, $phone) 
    {
        if ($this->isEmailExists($email, $this->db)) {
            $_SESSION["errMsg"] = "Email already exists!";
            return false;
        }
        
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO admins (name, email, password, phone) VALUES ('$name', '$email', '$password', '$phone')";
        
        if ($conn->query($sql)) {
            return true;
        } else {
            $_SESSION["errMsg"] = "Database error: " . $conn->error;
            return false;
        }
    }

    public function getAllAdmins() 
    {
        $this->db->openConnection();
        $query = "SELECT name, phone FROM admins";

        $result = $this->db->select($query);

        if (count($result) > 0) { 
            return $result;
        }

        return [];
    }
}
?>
