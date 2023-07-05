<?php

    namespace App\Connection;

    class Delete{

        private $dbAccess;
        private $queryBuilder;

        public function __construct($dbAccess, $queryBuilder)
        {
            $this->dbAccess = $dbAccess;
            $this->queryBuilder = $queryBuilder;
        }

        public function deleteTables($tablesToDelete = null){
            
            $quries = $this->queryBuilder->deleteTableQueries($tablesToDelete);

            foreach($quries as $query){

                $this->dbAccess->executeQuery($query);
                
            }
            
        }


    }

?>