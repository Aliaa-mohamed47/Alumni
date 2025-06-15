<?php
    require_once '../../Models/admin.php';
    require_once '../../Models/alumni.php';
    require_once '../../Models/student.php';
    require_once '../../Controlers/DBControler.php';

    class FeedbackControler
    {
        protected $db;
        //1) Open connection
        //2) Run query
        //3) Close connection
        // private $db;


        public function __construct() 
        {
            $this->db = new DBControler();
            $this->db->openConnection();
        }

        public function sendFeedback($userId, $userRole, $feedback, $email)
        {
            $feedback = $this->db->getConnection()->real_escape_string($feedback);
            $email = $this->db->getConnection()->real_escape_string($email);
    
            if ($userRole == 'alumni') {
                $qry = "INSERT INTO feedbacks (feedback, alumni_id, email) VALUES ('$feedback', '$userId', '$email')";
            } else {
                $qry = "INSERT INTO feedbacks (feedback, student_id, email) VALUES ('$feedback', '$userId', '$email')";
            }
    
            if ($this->db->getConnection()->query($qry)) {
                return true;
            } else {
                echo "Error submitting feedback: " . $this->db->getConnection()->error;
                return false;
            }
        }

        public function getAllFeedback()
        {
            if (!$this->db->openConnection()) {
                $_SESSION["errMsg"] = "Database connection error.";
                return [];
            }

            $conn = $this->db->getConnection();

            $query = "
                SELECT f.feedback, f.created_at, f.email,
                    s.name AS student_name, a.name AS alumni_name
                FROM feedbacks f
                LEFT JOIN students s ON f.student_id = s.id
                LEFT JOIN alumnis a ON f.alumni_id = a.id
            ";

            $result = $conn->query($query);
            $feedbackList = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $role = $row['student_name'] ? 'student' : 'alumni';
                    $sender_name = $row['student_name'] ?: $row['alumni_name'];

                    $feedbackList[] = [
                        'feedback' => $row['feedback'],
                        'email' => $row['email'],
                        'created_at' => $row['created_at'],
                        'sender_name' => $sender_name,
                        'role' => $role
                    ];
                }
            }

            return $feedbackList;
        }
    }
    ?>