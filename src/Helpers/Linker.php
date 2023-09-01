<?php

    namespace Framework\Helpers;

    use Framework\Helpers\Files;
    use Framework\Helpers\RegexHelper;

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


                $componentArgs = $this->extractComponentAttributes($match, $componentName, $page);


                $page = $this->resolveComponentString($match, $componentArgs, $componentName, $page);

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

            preg_match_all("/{{([^{}]+)}}/", $page, $matches);


            for($i = 0; $i < count($matches[1]); $i++){

                $match = $matches[1][$i];


                $regexSearch = "";


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

            $pattern = RegexHelper::preparePattern($match);

            if(preg_match("/<x-$pattern>([\p{Any}]*?)<\/x-$temp>/", $page, $searchResult)){
                $componentArgs["children"] = $searchResult[1];
            }
            else{
                $componentArgs["children"] = null;
            }

            return $componentArgs;
        }

        private function extractComponentName($string){

            preg_match("/\b([\w.-]+)/", $string, $searchResult);

            return $searchResult[1];

        }

        private function resolveComponentString($match, $componentArgs, $componentName, $page){


            $componentPath = $this->fileController->convertComponentToPath($componentName);

            $componentString = file_get_contents($this->fileController->makePath("/app/Pages/components/$componentPath.php"));         

            $componentString = $this->resolveComponents($componentString);


            if($componentArgs['children'] != null){
                return str_replace("<x-$match>" . $componentArgs['children'] . "</x-$componentName>", $this->resolveComponentParams($componentString, $componentArgs) ,$page);
            }
            else{
                return str_replace("<x-$match>", $this->resolveComponentParams($componentString, $componentArgs) ,$page);
            }
            
        }
    }

?>