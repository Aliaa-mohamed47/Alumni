<?php
require_once '../../Controlers/DBControler.php';


class Event {
    public $id;
    public $title;
    public $description;
    public $date;
    public $location;
    public $event_attendance;

    public function __construct($id, $title, $description, $date, $location, $event_attendance) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->location = $location;
        $this->event_attendance = $event_attendance;
    }

    public function saveEvent($dbController) 
        {
            if (!$dbController->openConnection()) 
            {
                return false;
            }

            $conn = $dbController->getConnection();

            $query = "INSERT INTO events (title, description, date, location, event_attendance) VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssi", $this->title, $this->description, $this->date, $this->location, $this->event_attendance);

            if ($stmt->execute()) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
        }
}
?>
