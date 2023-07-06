<?php

    namespace App\Connection;

    use App\Helpers\SuccessHandler;
    use App\Interfaces\FilesInterface;
    use App\Helpers\Files;

    class Migration implements FilesInterface{

        use Files;

        private $dbAccess;
        private $queryBuilder;

        public function __construct($dbAccess, $queryBuilder){
            $this->dbAccess = $dbAccess;
            $this->queryBuilder = $queryBuilder;
        }


        public function migrateTable($tablesToMigrate = null){
            
            $queries = $this->queryBuilder->buildTableQueries($tablesToMigrate);

            foreach($queries as $query){
                $this->dbAccess->executeQuery($query);
            }

            

            if($tablesToMigrate == null){
                SuccessHandler::migrationSucceeded($this->readDir('/database/tables'));
            }else{
                SuccessHandler::migrationSucceeded($tablesToMigrate);
            }
            
        }

    }

?>