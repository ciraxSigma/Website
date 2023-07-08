<?php

    namespace App\Connection;

    use App\Query\DatabaseAccess;
    use App\Query\Builder;
    use App\Helpers\SuccessHandler;


    class Delete{

        private $dbAccess;
        private $queryBuilder;

        public function __construct()
        {
            $this->dbAccess = new DatabaseAccess();
            $this->queryBuilder = new Builder();
        }

        public function deleteTables($tablesToDelete = null){

            $queries = [];

            if($tablesToDelete == null){
                $getAllTablesQuery = $this->queryBuilder->getAllTablesQuery();
                $tablesToDelete = $this->dbAccess->executeReturnQuery($getAllTablesQuery);
            }

            $queries = $this->queryBuilder->deleteTableQueries($tablesToDelete);
            
            

            foreach($queries as $query){

                $this->dbAccess->executeNoReturnQuery($query);
                
            }

            SuccessHandler::deleteSucceeeded($tablesToDelete);
            
        }


    }

?>