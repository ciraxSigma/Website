<?php


    namespace App\Query;

    use mysqli;
    use Exception;


    class DatabaseAccess{

        private $mysqli;

        public function __construct(){

            try {
                $this->mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
            } catch (Exception $e) {
                echo "Error connecting to the database: " . $e->getMessage();
            }
            
            if($this->mysqli->connect_errno){
                echo "Connection Error: " . $this->mysqli->connect_error;
            }

        }


        public function executeNoReturnQuery($query){
            
            $stmt = $this->mysqli->prepare($query);
            
            $stmt->execute();

        }

        public function executeReturnQuery($query){

            $stmt = $this->mysqli->prepare($query);

            $stmt->execute();

            $mysqliResult = $stmt->get_result();

            $results = [];
            
            while($row = $mysqliResult->fetch_assoc()){
                $results[] = $row['Tables_in_' . $_ENV["DB_NAME"]];
            }

            return $results;

        }

    }

?>