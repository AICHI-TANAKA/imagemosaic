<?php

    function image_convert_php($file_name){
        $command = "C:\\Python\\Python311\\python.exe face-mosaic.py ".$file_name." 2>&1";
        try{
            exec($command,$dum,$rtn);
            $result = mb_convert_encoding($dum,"UTF-8","SJIS");
            var_dump($result);

            return true;
        }catch (Exception $e){
            echo "加工処理に失敗しました。".$e->getMessage();
            echo "<br>もう一度お試しください";
            return false;
        }
    }

    // if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //     image_convert_js($_GET['name']);
    // }
    // image_convert_js('h-1.jpg');
    image_convert_php($_GET['name']);
?>
