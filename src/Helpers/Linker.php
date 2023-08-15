<?php

    namespace Framework\Helpers;

    use Framework\Helpers\Files;

    class Linker{

        private $fileController;

        public function __construct()
        {
            $this->fileController = new Files();

        }

        public function link($page, $data){
            

            $componentsPath = $this->fileController->makePath("/app/Pages/components");


            if(file_exists($componentsPath)){
                $page = $this->resolveComponents($page);
            }

            $page = $this->resolvePageParams($page, $data);


            return $page;
        }

        private function resolveComponents($page){

            $matches = array();

            preg_match_all("/<x-([^<>]+)>/", $page, $matches);
            
            for($i = 0; $i < count($matches[1]); $i++){

                $match = $matches[1][$i];

                $componentName = $this->extractComponentName($match);

                $componentPath = $this->fileController->convertComponentToPath($componentName);

                $componentArgs = $this->extractComponentAttributes($match, $componentName, $page);

                $componentString = file_get_contents($this->fileController->makePath("/app/Pages/components/$componentPath.php"));

                $componentString = $this->resolveComponents($componentString);

                $page = str_replace("<x-$match>" . $componentArgs['children'] . "</x-$componentName>", $this->resolveComponentParams($componentString, $componentArgs) ,$page);

            }

            return $page;
            
        }

        private function resolveComponentParams($componentString, $params){

            $matches = array();

            if($params != null){
                extract($params);
            }

            preg_match_all("/{{([$][\w_]+)}}/", $componentString, $matches);

            for($i = 0; $i < count($matches[1]); $i++){


                $match = $matches[1][$i];

                $regexSearch = "{{".$match."}}";
                
                eval("\$variable = $match;");
                
                $componentString = str_replace($regexSearch, $variable , $componentString);
                
            }

            return $componentString;

        }

        private function resolvePageParams($page, $data){

            if($data != null){

                extract($data);

            }

            $matches = array();

            preg_match_all("/{{([$][\w]+)}}/", $page, $matches);


            for($i = 0; $i < count($matches[1]); $i++){

                $match = $matches[1][$i];

                $regexSearch = "{{".$match."}}";

                eval("\$variable = $match;");

                $page = str_replace($regexSearch, $variable, $page);
                
            }

            return $page;
        }

        private function extractComponentAttributes($match, $componentName, $page){

            $searchResult = array();

            preg_match_all("/\b(\w+)=['\"]([\w ]+)['\"]/", $match, $searchResult);
            
            $componentArgs = array_combine($searchResult[1], $searchResult[2]);

            preg_match_all("/:([\w]+)=({{[$][\w]+}})/", $match, $searchResult);

            $componentArgs = array_merge($componentArgs, array_combine($searchResult[1], $searchResult[2]));

            $temp = str_replace("/", '.', $componentName);

            $match = str_replace("$", "\\$", $match);

            preg_match("/<x-$match>([^\0]*)<\/x-$temp>/", $page, $searchResult);

            $componentArgs["children"] = $searchResult[1];

            return $componentArgs;
        }


        private function extractComponentName($string){

            preg_match("/\b([\w.]+)/", $string, $searchResult);

            return $searchResult[1];

        }

    }

?>