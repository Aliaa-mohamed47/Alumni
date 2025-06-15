<?php

class NotificationObserver implements Observer {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function update($jobData) {
        $stmt = mysqli_prepare($this->db, "INSERT INTO notifications (alumni_id, message) VALUES (?, ?)");
        $message = "New job posted: {$jobData['jobTitle']} at {$jobData['company']}";
        mysqli_stmt_bind_param($stmt, "is", $jobData['alumniId'], $message);
        mysqli_stmt_execute($stmt);
    }
}

?>