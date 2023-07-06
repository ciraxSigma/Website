<?php

    use App\Connection\Migration;
    use App\Query\Builder;
    use App\Query\DatabaseAccess;

    $migration = new Migration(new DatabaseAccess(), new Builder());

    if(count($argv) == 1){

        $migration->migrateTable();

    }else{

        array_shift($argv);

        $migration->migrateTable($argv);
    }


?>