<?php
    class Nodemcu_log{

        // Connection
        private $conn;

        // Table
        private $db_table = "multisensor";

        // Columns
        public $id;
        public $sensor_suhu;
        public $sensor_ph;
        public $sensor_do;
        public $sensor_amonia;
        public $sensor_suhu_baterai;
        public $sensor_arus;
        public $sensor_tegangan;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL DATA
        public function getLogData(){
            $sqlQuery = "SELECT id, sensor_suhu, sensor_ph, sensor_do, sensor_amonia, sensor_suhu_baterai, sensor_arus, sensor_tegangan FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createLogData(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        sensor_suhu = :sensor_suhu, 
                        sensor_ph = :sensor_ph,
                        sensor_do = :sensor_do,
                        sensor_amonia = :sensor_amonia, 
                        sensor_suhu_baterai = :sensor_suhu_baterai,
                        sensor_arus = :sensor_arus,
                        sensor_tegangan = :sensor_tegangan";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->sensor_suhu=htmlspecialchars(strip_tags($this->sensor_suhu));
            $this->sensor_ph=htmlspecialchars(strip_tags($this->sensor_ph));
            $this->sensor_do=htmlspecialchars(strip_tags($this->sensor_do));
            $this->sensor_amonia=htmlspecialchars(strip_tags($this->sensor_amonia));
            $this->sensor_suhu_baterai=htmlspecialchars(strip_tags($this->sensor_suhu_baterai));
            $this->sensor_arus=htmlspecialchars(strip_tags($this->sensor_arus));
            $this->sensor_tegangan=htmlspecialchars(strip_tags($this->sensor_tegangan));

        
            // bind data
            $stmt->bindParam(":sensor_suhu", $this->sensor_suhu);
            $stmt->bindParam(":sensor_ph", $this->sensor_ph);
            $stmt->bindParam(":sensor_do", $this->sensor_do);
            $stmt->bindParam(":sensor_amonia", $this->sensor_amonia);
            $stmt->bindParam(":sensor_suhu_baterai", $this->sensor_suhu_baterai);
            $stmt->bindParam(":sensor_arus", $this->sensor_arus);
            $stmt->bindParam(":sensor_tegangan", $this->sensor_tegangan);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // fetch single
        public function getSingleLogData(){
            $sqlQuery = "SELECT
                        id, 
                        sensor_suhu, 
                        sensor_ph, 
                        sensor_do
                        sensor_amonia, 
                        sensor_suhu_baterai, 
                        sensor_arus
                        sensor_tegangan, 

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
					$this->sensor_suhu = $dataRow['sensor_suhu'];
					$this->sensor_ph = $dataRow['sensor_ph'];
					$this->sensor_do = $dataRow['sensor_do'];
					$this->sensor_amonia = $dataRow['sensor_amonia'];
					$this->sensor_suhu_baterai = $dataRow['sensor_suhu_baterai'];
					$this->sensor_arus = $dataRow['sensor_arus'];
					$this->sensor_tegangan = $dataRow['sensor_tegangan'];

				}
			} else {
				$errors = $stmt->errorInfo();
				echo($errors[2]);
			}
			
            //$dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            //$this->sensor_suhu = $dataRow['sensor_suhu'];
            //$this->sensor_ph = $dataRow['sensor_ph'];
            //$this->sensor_do = $dataRow['sensor_do'];
            //$this->sensor_amonia = $dataRow['sensor_amonia'];
            //$this->sensor_suhu_baterai = $dataRow['sensor_suhu_baterai'];
            //$this->sensor_arus = $dataRow['sensor_arus'];
            //$this->sensor_tegangan = $dataRow['sensor_tegangan'];
}        

        // Edit Data
        public function updateDataLog(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        sensor_suhu = :sensor_suhu, 
                        sensor_ph = :sensor_ph,  
                        sensor_do = :sensor_do,
                        sensor_amonia = :sensor_amonia, 
                        sensor_suhu_baterai = :sensor_suhu_baterai,  
                        sensor_arus = :sensor_arus,
                        sensor_tegangan = :sensor_tegangan
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->sensor_suhu=htmlspecialchars(strip_tags($this->sensor_suhu));
            $this->sensor_ph=htmlspecialchars(strip_tags($this->sensor_ph));
            $this->sensor_do=htmlspecialchars(strip_tags($this->sensor_do));
            $this->sensor_amonia=htmlspecialchars(strip_tags($this->sensor_amonia));
            $this->sensor_suhu_baterai=htmlspecialchars(strip_tags($this->sensor_suhu_baterai));
            $this->sensor_arus=htmlspecialchars(strip_tags($this->sensor_arus));
            $this->sensor_tegangan=htmlspecialchars(strip_tags($this->sensor_tegangan));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":sensor_suhu", $this->sensor_suhu);
            $stmt->bindParam(":sensor_ph", $this->sensor_ph);
            $stmt->bindParam(":sensor_do", $this->sensor_do);
            $stmt->bindParam(":sensor_amonia", $this->sensor_amonia);
            $stmt->bindParam(":sensor_suhu_baterai", $this->sensor_suhu_baterai);
            $stmt->bindParam(":sensor_arus", $this->sensor_arus);
            $stmt->bindParam(":sensor_tegangan", $this->sensor_tegangan);

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

