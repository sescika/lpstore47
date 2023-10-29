<?php
    define("envPath",__DIR__."/.env");
    
    define("SERVER", env("SERVER"));
    define("DATABASE", env("DATABASE"));
    define("USERNAME", env("USERNAME"));
    define("PASSWORD", env("PASSWORD"));
    function env($marker){
        $niz = file(envPath);
        $trazenaVrednost = "";
    
        foreach($niz as $red){
            $red = trim($red);
    
            list($identifikator, $vrednost) = explode("=", $red);
    
            if($identifikator == $marker){
                $trazenaVrednost = $vrednost;
                break;
            }
        }
    
        return $trazenaVrednost;
    }
?>