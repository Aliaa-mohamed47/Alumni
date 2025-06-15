<?php
    require_once '../../Models/admin.php';
    require_once '../../Models/donation.php';
    require_once '../../Models/student.php';
    require_once '../../Controlers/DBControler.php';

    class DonationControler
    {
        protected $db;
        //1) Open connection
        //2) Run query
        //3) Close connection
        // private $db;


        public function __construct()
        {
            $this->dbController = new DBControler();
            $this->dbController->openConnection();
        }

        public function donate($donorName, $email, $amount)
        {
            if (!isset($_SESSION["userId"])) {
                return ["status" => "error", "message" => "Alumni not logged in."];
            }

            $alumniId = $_SESSION["userId"];
            $payment_method = 'Fawry';
            $notes = "Online donation by $donorName ($email)";

            $db = new DBControler();

            if (!$db->openConnection()) {
                return ["status" => "error", "message" => "Database connection error."];
            }

            $conn = $db->getConnection();
            $sql = "INSERT INTO donations (amount, alumniId, adminId, payment_method, notes)
                    VALUES (?, ?, NULL, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $db->closeConnection();
                return ["status" => "error", "message" => "Database prepare failed: " . $conn->error];
            }

            $stmt->bind_param("diss", $amount, $alumniId, $payment_method, $notes);

            if ($stmt->execute()) {
                $stmt->close();
                $db->closeConnection();
                return ["status" => "success", "message" => "Donation recorded successfully."];
            } else {
                $errorMsg = $stmt->error;
                $stmt->close();
                $db->closeConnection();
                return ["status" => "error", "message" => "Database execute failed: " . $errorMsg];
            }
        }

        public function collectDonations()
        {
            $conn = $this->db->getConnection();

            if ($conn === null) {
                return ["status" => "error", "message" => "Database connection failed."];
            }

            $sql = "SELECT alumniId, amount, notes, date FROM donations";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                return ["status" => "error", "message" => "Failed to prepare the query."];
            }

            $stmt->execute();
            $donationsResult = $stmt->get_result();

            $sqlTotal = "SELECT SUM(amount) AS totalAmount FROM donations";
            $stmtTotal = $conn->prepare($sqlTotal);

            if ($stmtTotal === false) {
                return ["status" => "error", "message" => "Failed to prepare total query."];
            }

            $stmtTotal->execute();
            $totalAmountResult = $stmtTotal->get_result();
            $totalAmount = $totalAmountResult->fetch_assoc()['totalAmount'];

            return [
                "status" => "success",
                "totalAmount" => $totalAmount,
                "donations" => $donationsResult
            ];
        }

        public function __destruct()
        {
            $this->dbController->closeConnection();
        }

    }
?>