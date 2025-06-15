<?php
    require_once '../../Models/admin.php';
    require_once '../../Models/alumni.php';
    require_once '../../Models/student.php';
    require_once '../../Controlers/DBControler.php';
    require_once '../../Models/Event.php';

    class EventControler
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

        
        public function addEvent($title, $description, $date, $location, $event_attendance)
        {
            if (!$this->db->openConnection()) {
                $_SESSION["errMsg"] = "Database connection error.";
                return false;
            }

            $event = new Event(null, $title, $description, $date, $location, $event_attendance);

            if ($event->saveEvent($this->db)) {
                $_SESSION["successMsg"] = "Event added successfully!";
                return true;
            } else {
                $_SESSION["errMsg"] = "Error saving the event.";
                return false;
            }
        }

        public function getAllEvents() 
        {
            return $this->db->select("SELECT * FROM events");
        }

        public function deleteEvent($id) {
            $id = intval($id);
            return $this->db->update("DELETE FROM events WHERE id = $id");
        }

        public function getEventById($eventId) 
        {
            $query = "SELECT * FROM events WHERE id = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        
        public function updateEvent($eventId, $title, $description, $date, $location) 
        {
            $query = "UPDATE events SET title = ?, description = ?, date = ?, location = ? WHERE id = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("ssssi", $title, $description, $date, $location, $eventId);
            return $stmt->execute();
        }

        public function editEvent($eventId, $title, $description, $date, $location) 
        {
            if (!$this->db->openConnection()) {
                $_SESSION["errMsg"] = "Database connection error.";
                return false;
            }
    
            $query = "UPDATE events SET title = ?, description = ?, date = ?, location = ? WHERE id = ?";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bind_param("ssssi", $title, $description, $date, $location, $eventId);
    
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function updateSpeakerStatus($speakerId) 
        {
            $updateQuery = "UPDATE event_speakers SET speaker_status = 'confirmed' WHERE id = $speakerId";
            
            if ($this->db->update($updateQuery)) {
                $_SESSION['successMsg'] = "the speaker has been confirmed successfully!";
            } else {
                $_SESSION['errMsg'] = "An error occurred while confirming the speaker.";
            }
        }
    
        public function deleteSpeaker($speakerId) 
        {

            $deleteQuery = "DELETE FROM event_speakers WHERE id = $speakerId";
            
            if ($this->db->update($deleteQuery)) {
                $_SESSION['successMsg'] = "the speaker has been deleted successfully!";
            } else {
                $_SESSION['errMsg'] = "An error occurred while deleting the speaker.";
            }
        }

        public function getEventSpeakersWithAttendance($eventId) 
        {
            $query = "SELECT es.attended, e.title AS event_name, 
                        a.name AS alumni_name, a.email AS alumni_email
                    FROM event_speakers es
                    LEFT JOIN alumnis a ON es.alumni_id = a.id
                    LEFT JOIN events e ON es.event_id = e.id
                    WHERE es.event_id = ?";

            $result = $this->db->selectt($query, [$eventId]);
            
            if ($result) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                var_dump($data); 
                return $data;
            } else {
                echo "Error: " . mysqli_error($this->db->getConnection());
                return [];
            }
        }


        public function updateAttendanceStatus($eventId, $alumniId, $newStatus) 
        {
            $query = "UPDATE event_speakers SET attended = ? WHERE event_id = ? AND alumni_id = ?";
            $this->db->insertt($query, [$newStatus, $eventId, $alumniId]);
        }


}


?>