<?php
    require_once '../../Models/admin.php';
    require_once '../../Models/alumni.php';
    require_once '../../Models/student.php';
    require_once '../../Controlers/DBControler.php';

    class AlumniControler
    {
        protected $db;
        //1) Open connection
        //2) Run query
        //3) Close connection
        // private $db;


        public function __construct()
        {
            $this->db = new DBControler;
        }

        public function deleteAlumni($id)
        {
            $db = new DBControler();
            $db->openConnection();

            $qry = "DELETE FROM alumnis WHERE id = ?";
            $stmt = $db->getConnection()->prepare($qry);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
            
            $db->closeConnection();
        }

        
        public function getAllAlumnis() 
        {
            $this->db->openConnection();
            $query = "SELECT * FROM alumnis";
            $result = $this->db->select($query);
            $this->db->closeConnection();
            return $result;
        }
        
        public function getAllAlumniss() 
        {
            $this->db->openConnection();
            $query = "SELECT id, name, email, graduation_year, department, job_title, phone FROM alumnis";
            $result = $this->db->select($query);
            $this->db->closeConnection();
            return $result;
        }

        
        public function updateAlumniRating($alumniId, $rating)
        {
            if (!$this->db->openConnection()) {
                return false;
            }

            $stmt = $this->db->getConnection()->prepare("UPDATE alumnis SET rating = ? WHERE id = ?");
            $stmt->bind_param("ii", $rating, $alumniId);
            $result = $stmt->execute();

            $this->db->closeConnection();
            return $result;
        }

        public function searchAlumni($searchTerm) 
        {
            $searchTerm = trim($searchTerm);

            if (empty($searchTerm)) {
                return [];
            }

            $this->db->openConnection();

            $query = "SELECT * FROM alumnis WHERE name LIKE ? OR email LIKE ?";
            $stmt = $this->db->getConnection()->prepare($query);

            $searchTermWithPercent = "$searchTerm%";
            $stmt->bind_param("ss", $searchTermWithPercent, $searchTermWithPercent);

            $stmt->execute();
            $result = $stmt->get_result();

            $this->db->closeConnection();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getAlumniByRating($sortOrder = 'desc') 
        {
            if (!$this->db->openConnection()) {
                return false;
            }
        
            $query = "SELECT * FROM alumnis ORDER BY rating $sortOrder ,name ASC";

            $result = $this->db->select($query);
            $this->db->closeConnection();
            
            return $result;
        }
        
        public function sendJobs($jobTitle, $company, $location, $jobType, $description, $applyLink, $alumniId, $adminId) 
        {
            $db = new DBControler();
            if ($db->openConnection()) {
                $conn = $db->getConnection();

                $checkQuery = mysqli_prepare($conn, "SELECT id FROM alumnis WHERE id = ?");
                mysqli_stmt_bind_param($checkQuery, "i", $alumniId);
                mysqli_stmt_execute($checkQuery);
                $result = mysqli_stmt_get_result($checkQuery);

                if (mysqli_num_rows($result) === 0) {
                    $_SESSION['errMsg'] = "Alumni ID does not exist.";
                    return false;
                }

                $query = mysqli_prepare($conn, "INSERT INTO jobs (title, description, adminId, company, location, job_type, apply_link, alumni_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($query, "sssisssi", $jobTitle, $description, $adminId, $company, $location, $jobType, $applyLink, $alumniId);
                
                if (mysqli_stmt_execute($query)) {
                    return true;
                } else {
                    $_SESSION['errMsg'] = "Failed to insert job.";
                    return false;
                }
            } else {
                $_SESSION['errMsg'] = "Database connection failed.";
                return false;
            }
        }


    }

?>