<?php

    namespace App\Connection;

use App\Helpers\ErrorHandler;
use App\Helpers\SuccessHandler;
    use App\Helpers\Files;
use App\Helpers\UserInputHandler;
use App\Helpers\WarningHandler;
use App\Query\Builder;
    use App\Query\DatabaseAccess;

    class Migration{

        private $dbAccess;
        private $queryBuilder;
        private $fileController;

        public function __construct(){
            $this->dbAccess = new DatabaseAccess();
            $this->queryBuilder = new Builder();
            $this->fileController = new Files();
        }

        private function deleteTableIfExists($tablesToMigrate){

            $tablesInDB = $this->dbAccess->executeReturnQuery($this->queryBuilder->getAllTablesQuery());
            $tablesToDelete = [];

            if($tablesToMigrate == null){

                $tablesToMigrate = $this->fileController->readDir('/database/tables');

            }

            foreach($tablesToMigrate as $tableName){

                foreach($tablesInDB as $tableInDB){

                    if(lcfirst($tableName) == $tableInDB){
                        
                        WarningHandler::tableExistsWarning($tableInDB);
                        
                        $userInput = UserInputHandler::dropTableInput($tableInDB);
                        
                        if($userInput != "yes"){
                            ErrorHandler::tableAlreadyExistsError();

                        }else{
                            $tablesToDelete[] = $tableInDB;                              
                        }

                    }

                }
                
            }

            $deleteTablesQueries = $this->queryBuilder->deleteTableQueries($tablesToDelete);
            
            foreach($deleteTablesQueries as $deleteTablesQuery){
                $this->dbAccess->executeNoReturnQuery($deleteTablesQuery);
            }

        }


        public function migrateTable($tablesToMigrate = null){  
            
            $this->deleteTableIfExists($tablesToMigrate);

            $queries = $this->queryBuilder->buildTableQueries($tablesToMigrate);

            foreach($queries as $query){
                $this->dbAccess->executeNoReturnQuery($query);
            }

            if($tablesToMigrate == null){
                SuccessHandler::migrationSucceeded($this->fileController->readDir('/database/tables'));
            }else{
                SuccessHandler::migrationSucceeded($tablesToMigrate);
            }
            
        }

    }

?>