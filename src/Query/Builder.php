<?php

    namespace App\Query;

    use App\Helpers\Files;
    use App\Interfaces\FilesInterface;
    use App\Helpers\ErrorHandler;

    class Builder implements FilesInterface{

        use Files;
        

        public function buildTableQueries($tablesToMigrate = null){

            $tableQueries = [];
            $tables = [];

            if($tablesToMigrate == null){

                $tables = $this->readDir('/database/tables');

            }else{

                $tables = $tablesToMigrate;

            }
            

            foreach($tables as $table){

                $tableFileName = $this->addExtension($table);

                $columnProperties = require($this->makePath("/database/tables/" . $tableFileName));

                $tableQueries[] = $this->resolveTableColumnProperties($columnProperties, lcfirst($table));
            }

            return $tableQueries;

        }


        private function resolveTableColumnProperties($columnProperties, $tableName){

            $formatedColumnProperties = [];
            
            foreach($columnProperties as $columnName => $propertiesString){

                $currentTypeArr = [];

                foreach(explode("|" , $propertiesString) as $property){
                    
                    $currentTypeArr["name"] = $columnName;

                    switch ($property){

                        case "int":
                            $currentTypeArr["type"] = "int";
                            break;
                        case "varchar":
                            $currentTypeArr["type"] = "varchar (255)";
                            break;
                        case "key":
                            $currentTypeArr["key"] = "PRIMARY KEY($columnName)";
                            break;
                        case "auto_increment":
                            $currentTypeArr["auto_increment"] = "AUTO_INCREMENT";
                            break;
                        case "nullable":
                            $currentTypeArr["nullable"] = "NULL";
                            break;
                        default:
                            ErrorHandler::ColumnValidationError($tableName, $columnName, $propertiesString);
                            
                    }

                }

                $formatedColumnProperties[] = $currentTypeArr;

            }

            return $this->makeColumnsSql($formatedColumnProperties, $tableName);

        }


        private function makeColumnsSql($formatedColumnProperties, $tableName){

            $sql = "";
            $counter = 0;

            foreach($formatedColumnProperties as $formatedColumnProperty){
                $counter++;
                    
                if(isset($formatedColumnProperty['name'])){
                    $sql .= $formatedColumnProperty['name'] . " ";
                }

                if(isset($formatedColumnProperty['type'])){
                    $sql .= $formatedColumnProperty['type']  . " ";
                }

                if(isset($formatedColumnProperty['nullable'])){
                    $sql .= "NULL ";
                }else{
                    $sql .= "NOT NULL ";
                }

                if(isset($formatedColumnProperty['auto_increment'])){
                    $sql .= $formatedColumnProperty['auto_increment']  . " ";
                }
                
                if($counter != count($formatedColumnProperties)){
                    $sql .= ', ';
                }
                
            }

            foreach($formatedColumnProperties as $formatedColumnProperty){
                if(isset($formatedColumnProperty['key'])){
                    $sql .= ', '. $formatedColumnProperty['key'];
                    break;
                }
            }

            return "CREATE TABLE $tableName ($sql)";
        }

        public function deleteTableQueries($tablesToDelete = null){

            $tableQueries = [];
            $tables = [];

            if($tablesToDelete == null){

                $tables = $this->readDir('/database/tables');

            }else{

                $tables = $tablesToDelete;

            }

            foreach($tables as $table){
                
                $lowerCaseTableName = lcfirst($table);

                $tableQueries[] = "DROP TABLE $lowerCaseTableName";

            }

            foreach ($tableQueries as $query){
                echo $query . "\n";
            }

            return $tableQueries;

        }

    }

?>