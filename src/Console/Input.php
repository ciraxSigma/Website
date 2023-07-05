<?php

    namespace App\Console;
    
    use App\Helpers\Files;
    use App\Interfaces\FilesInterface;

    class Input implements FilesInterface{
        
        use Files;

        /**
         * Array of arguments
         */
        private $input = [];

        
        /**
         * Input constructor will shift $argv array so that first arg
         * is ommited in $input array. First argument is artisan.
         * 
         * 
         * @param $argv
         * Global $argv array
         */

         
        public function __construct($argv)
        {
            array_shift($argv);
            $this->input = $argv;

            if($command = $this->validateInput()){
                require($this->getBasePath() . "/src/Executes/" . $command . ".php");
            }
            else{
                echo "This command doesn't exist! \n";
            }
            
        }

        private function validateInput(){

            $path = "/src/Executes";

            $files = $this->readDir($path);


            $commandParts = explode(':', $this->input[0]);

            $command = ucwords($commandParts[0]) . ucwords($commandParts[1]);

            foreach($files as $file){

                if($file == $command){

                    return $command;
                }
            }

            return null;

        }
    }

?>