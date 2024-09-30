<?php
    
    const base_url = "http://localhost:8012/BASE_DATOS/";
    const host = "localhost";
    const user = "root";
    const pass = "";
    const db = "heladeria";
    const charset = "charset=utf8";

    $dsn = "mysql:host=" . host . ";dbname=" . db . ";" . charset;

    $conn = new PDO($dsn,user, pass);


    function unique_id(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLength = strlen($chars);
        $randomString = '';
        for($i=0; $i < 20; $i++){
            $randomString.=$chars[mt_rand(0, $charsLength-1)];
        }
        return $randomString;
    }
?>