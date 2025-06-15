<?php
    require_once '../../Models/admin.php';
    require_once '../../Models/alumni.php';
    require_once '../../Models/student.php';
    require_once '../../Controlers/DBControler.php';
    require_once '../../Models/UserFactory.php';
    require_once '../../Models/Event.php';

    class AuthControler
    {
        protected $db;
        //1) Open connection
        //2) Run query
        //3) Close connection


        public function login($email, $password, $role) 
        {
            try 
            {
                $user = UserFactory::createUser($role);
                
                if ($user->login($email, $password)) 
                {
                    // إضافة الـ ID في السيشن بناءً على الدور
                    if ($role == 'admin') {
                        $_SESSION['adminid'] = $user->getId(); // تأكد إن الـ getId() موجود في كلاس الـ Admin
                    } elseif ($role == 'alumni') {
                        $_SESSION['alumniid'] = $user->getId(); // تأكد إن الـ getId() موجود في كلاس الـ Alumni
                    } elseif ($role == 'student') {
                        $_SESSION['studentid'] = $user->getId(); // تأكد إن الـ getId() موجود في كلاس الـ Student
                    }

                    return true;
                } 
                else 
                {
                    throw new Exception("Invalid login credentials.");
                }
            } 
            catch (Exception $e) 
            {
                if (session_status() == PHP_SESSION_NONE) 
                {
                    session_start();
                }                
                $_SESSION["errMsg"] = $e->getMessage();
                return false;
            }
        }




        public function __construct()
        {
            $this->db = new DBControler;
        }


        public function register($name, $email, $password, $role, $sex, $level = null, $graduation_year = null, $department = null, $job_title = null)
        {
            if (!$this->db->openConnection()) 
            {
                $_SESSION['errMsg'] = "Database connection error.";
                return false;
            }

            $conn = $this->db->getConnection();

            $emailCheck = mysqli_prepare($conn, "SELECT email FROM students WHERE email = ? UNION SELECT email FROM alumnis WHERE email = ?");
            mysqli_stmt_bind_param($emailCheck, "ss", $email, $email);
            mysqli_stmt_execute($emailCheck);
            mysqli_stmt_store_result($emailCheck);

            if (mysqli_stmt_num_rows($emailCheck) > 0)
            {
                $_SESSION['errMsg'] = "Email already exists.";
                return false;
            }

            $plainPassword = $password;

            if ($role === 'student') 
            {
                if (empty($level)) 
                {
                    $_SESSION['errMsg'] = "Level is required for students.";
                    return false;
                }

                $query = "INSERT INTO students (name, email, password, sex, level) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $plainPassword, $sex, $level);
            } 
            elseif ($role === 'alumni')
            {
                if (empty($graduation_year) || empty($department) || empty($job_title)) 
                {
                    $_SESSION['errMsg'] = "Graduation year, department, and job title are required for alumni.";
                    return false;
                }

                $query = "INSERT INTO alumnis (name, email, password, sex, graduation_year, department, job_title) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ssssiss", $name, $email, $plainPassword, $sex, $graduation_year, $department, $job_title);
            } 
            else 
            {
                $_SESSION['errMsg'] = "Invalid role.";
                return false;
            }

            if (mysqli_stmt_execute($stmt)) 
            {
                $_SESSION['userId'] = mysqli_insert_id($conn);
                $_SESSION['userName'] = $name;
                $_SESSION['userRole'] = $role;
                return true;
            } 
            else 
            {
                $_SESSION['errMsg'] = "Error during registration.";
                return false;
            }
        }


        public function updatePassword($email, $oldPassword, $newPassword, $role) 
        {
            $db = new DBControler();
            if (!$db->openConnection()) 
            {
                $_SESSION['errMsg'] = "Database connection error.";
                return false;
            }

            $conn = $db->getConnection();

            if ($role === 'student') 
            {
                $table = 'students';
            } 
            elseif ($role === 'alumni') 
            {
                $table = 'alumnis';
            } 
            else 
            {
                $_SESSION['errMsg'] = "Invalid role.";
                return false;
            }

            $query = "SELECT password FROM $table WHERE email = ?";
            $stmt = mysqli_prepare($conn, $query);
            if (!$stmt) 
            {
                $_SESSION['errMsg'] = "Query preparation failed: " . mysqli_error($conn);
                return false;
            }

            mysqli_stmt_bind_param($stmt, "s", $email);
            if (!mysqli_stmt_execute($stmt)) 
            {
                $_SESSION['errMsg'] = "Query execution failed: " . mysqli_error($conn);
                return false;
            }

            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) 
            {
                $user = mysqli_fetch_assoc($result);

                if ($oldPassword === $user['password']) 
                {
                    $updateQuery = "UPDATE $table SET password = ? WHERE email = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    if (!$updateStmt) {
                        $_SESSION['errMsg'] = "Update query preparation failed: " . mysqli_error($conn);
                        return false;
                    }

                    mysqli_stmt_bind_param($updateStmt, "ss", $newPassword, $email);
                    if (mysqli_stmt_execute($updateStmt)) 
                    {
                        return true;
                    } 
                    else 
                    {
                        $_SESSION['errMsg'] = "Error updating password: " . mysqli_error($conn);
                        return false;
                    }
                } 
                else 
                {
                    $_SESSION['errMsg'] = "Old password is incorrect.";
                    return false;
                }
            } 
            else 
            {
                $_SESSION['errMsg'] = "Email not found.";
                return false;
            }
        }    
    }

?>