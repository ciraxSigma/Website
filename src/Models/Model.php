<?php

    namespace Framework\Models;

    use Framework\Query\DatabaseAccess;
    use Framework\Query\Builder;


    class Model{

        private $dbAccess;
        private $queryBuilder;

        
        protected $table = 'users';

        public function __construct(){
            $this->dbAccess = new DatabaseAccess();
            $this->queryBuilder = new Builder();
        }

        public function getAll(){
            $this->queryBuilder->getModelQuery($this->table);
            return $this;
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