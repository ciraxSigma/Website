<?php

    namespace Framework\Models;

    require("../../Testing.php");

    use Framework\Query\DatabaseAccess;
    use Framework\Query\Builder;

    class Model{

        public function __construct(){
            $this->dbAccess = new DatabaseAccess();
            $this->queryBuilder = new Builder();
        }

        public function __get($name){
            return $this->$name;
        }

        public function __set($name, $value){
            $this->$name = $value;
        }

        public static function start($columnsArray = null){

            $builder = Builder::getBuilder();

            $builder->getModelQuery(get_called_class()::$table, $columnsArray);

            return $builder;
        }


        public static function create($colValues){
            
            $db = DatabaseAccess::getDB();
            $builder = Builder::getBuilder();

            $db->createRecord($builder->create($colValues, get_called_class()::$table), $colValues);
            
            $model = new Model();

            foreach($colValues as $column => $value){
                $model->$column = $value;
            }

            return $model;
        }

        public static function print(){
            echo get_called_class()::$table;
        }


    }
?>