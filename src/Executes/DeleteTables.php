<?php

    use App\Connection\Delete;
    use App\Query\Builder;
    use App\Query\DatabaseAccess;

    $delete = new Delete(new DatabaseAccess(), new Builder());

    if(count($argv) == 1){

        $delete->deleteTables();

    }else{

        array_shift($argv);
        
        $delete->deleteTables($argv);

    }

?>