<?php

    class DBControler
    {
        public $dbHost="localhost";
        public $dbUser="root";
        public $dbPassword="";
        public $dbName="seproject";
        public $connection;
        public $dbPort = 3307;


        public function openConnection()
        {
            $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName, $this->dbPort);
            if($this->connection->connect_error)
            {
                echo "Error in Connection: ".$this->connection->connect_error;
                return false;
            }
            else
            {
                return true;
            }
        }

        public function closeConnection()
        {
            if($this->connection)
            {
                $this->connection->close();
            }
            else
            {
                echo "Connection is not opened";
            }
        }

        public function select($qry)
        {
            $result = $this->connection->query($qry);
            if ($result) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                echo "Error : " . mysqli_error($this->connection);
                return [];
            }
        }


        public function insert($qry)
        {
            $result=$this->connection->query($qry);
            if(!$result)
            {
                echo "Error : ".mysqli_error($this->connection);
                return false;
            }
            else
            {
                return $this->connection->insert_id;
            }
        }

        public function getConnection()
        {
            return $this->connection;
        }
        
        public function update($qry)
        {
            $result = $this->connection->query($qry);
            if (!$result) 
            {
                echo "Error : " . mysqli_error($this->connection);
                return false;
            } 
            else 
            {
                return true;
            }
        }

        public function selectt($query, $params = []) 
        {
            if ($this->connection !== null) {
                $stmt = $this->connection->prepare($query);
                if ($stmt) {
                    if (!empty($params)) {
                        $types = '';
                        $values = [];
                        foreach ($params as $param) {
                            $types .= 's';
                            $values[] = $param;
                        }
                        $stmt->bind_param($types, ...$values);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                    return $result;
                } else {
                    echo "Prepare failed: " . $this->connection->error;
                }
            }
            return false;
        }

        public function insertt($query, $params = []) 
        {
            if ($this->connection !== null) {
                $stmt = $this->connection->prepare($query);
                if ($stmt) {
                    if (!empty($params)) {
                        $types = '';
                        $values = [];
                        foreach ($params as $param) {
                            $types .= 's';
                            $values[] = $param;
                        }
                        $stmt->bind_param($types, ...$values);
                    }
                    if ($stmt->execute()) {
                        $insertId = $this->connection->insert_id;
                        $stmt->close();
                        return $insertId;
                    } else {
                        echo "Execute failed: " . $stmt->error;
                    }
                } else {
                    echo "Prepare failed: " . $this->connection->error;
                }
            }
            return false;
        }
    }
?>