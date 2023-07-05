<?php

    namespace App\Connection;

    class Migration{

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
            
        }

    }

?>