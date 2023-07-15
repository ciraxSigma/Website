<?php

    namespace Framework\Models;

    use Framework\Query\DatabaseAccess;
    use Framework\Query\Builder;
    use Framework\Helpers\Factory;

    class Model{

        private $dbAccess;
        private $queryBuilder;

        protected $table = '';

        public function __construct(){
            $this->dbAccess = new DatabaseAccess();
            $this->queryBuilder = new Builder();
        }

        public function getAll($columnsArray = null){
            return $this->start($columnsArray)->getData();
        }

        public function start($columnsArray = null){
            $this->queryBuilder->getModelQuery($this->table, $columnsArray);
            return $this;
        }

        public function where($columnName, $operator, $value){
            $this->queryBuilder->where($columnName, $operator, $value);
            return $this;
        }

        public function and($columnName, $operator, $value){
            $this->queryBuilder->and($columnName, $operator, $value);
            return $this;
        }

        public function or($columnName, $operator, $value){
            $this->queryBuilder->or($columnName, $operator, $value);
            return $this;
        }

        public function getData(){
            return $this->dbAccess->getData($this->queryBuilder->getQuery());
        }

        public function create($colValues){
            $this->dbAccess->createRecord($this->queryBuilder->create($colValues, $this->table), $colValues);
        }

    }

?>