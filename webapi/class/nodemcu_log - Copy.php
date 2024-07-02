<?php
    class Nodemcu_log{

        // Connection
        private $conn;

        // Table
        private $db_table = "station1";

        // Columns
        public $id;
        public $temperature;
        public $humidity;
        public $waktu;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL DATA
        public function getLogData(){
            $sqlQuery = "SELECT id, temperature, humidity, waktu FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createLogData(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        temperature = :temperature, 
                        humidity = :humidity";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->temperature=htmlspecialchars(strip_tags($this->temperature));
            $this->humidity=htmlspecialchars(strip_tags($this->humidity));
        
            // bind data
            $stmt->bindParam(":temperature", $this->temperature);
            $stmt->bindParam(":humidity", $this->humidity);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // fetch single
        public function getSingleLogData(){
            $sqlQuery = "SELECT
                        id, 
                        temperature, 
                        humidity, 
                        waktu
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
			//error handling
			if($stmt->errorCode() == 0) {
				while(($dataRow = $stmt->fetch(PDO::FETCH_ASSOC)) != false) {
					$this->temperature = $dataRow['temperature'];
					$this->humidity = $dataRow['humidity'];
					$this->waktu = $dataRow['waktu'];
				}
			} else {
				$errors = $stmt->errorInfo();
				echo($errors[2]);
			}
			
            //$dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            //$this->temperature = $dataRow['temperature'];
            //$this->humidity = $dataRow['humidity'];
            //$this->waktu = $dataRow['waktu'];
        }        

        // Edit Data
        public function updateDataLog(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        temperature = :temperature, 
                        humidity = :humidity,  
                        waktu = :waktu
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->temperature=htmlspecialchars(strip_tags($this->temperature));
            $this->humidity=htmlspecialchars(strip_tags($this->humidity));
            $this->waktu=htmlspecialchars(strip_tags($this->waktu));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":temperature", $this->temperature);
            $stmt->bindParam(":humidity", $this->humidity);
            $stmt->bindParam(":waktu", $this->waktu);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               $itemCount = $stmt->rowCount();
			   if($itemCount > 0){
					return true;
				}else{
					return false;
				}
            }
            return false;
        }

        // DELETE
        function deleteLogData(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

