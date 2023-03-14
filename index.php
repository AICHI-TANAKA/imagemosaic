<?php
    ini_set('display_errors', "On");
    session_start();

    function image_convert_js($file_name){
        // $command = "python face-mosaic.py ".$file_name." ".$mos_target;
        $command = "python face-mosaic.py ".$file_name;
        try{
            $result = exec($command);
            return true;
        }catch (Exception $e){
            echo "加工処理に失敗しました。".$e->getMessage();
            echo "<br>もう一度お試しください";
            return false;
        }
    }
    if(isset($_GET['name'])){
        function image_convert_php($file_name){
            // $command = "python face-mosaic.py ".$file_name." ".$mos_target;
            $command = "python face-mosaic.py ".$file_name;
            try{
                $result = exec($command);
                return true;
            }catch (Exception $e){
                echo "加工処理に失敗しました。".$e->getMessage();
                echo "<br>もう一度お試しください";
                return false;
            }
        }
    }

    function image_convert_php($file_name){
        $command = "C:\\Python\\Python311\\python.exe face-mosaic.py ".$file_name." 2>&1";
        try{
            exec($command,$dum,$rtn);
            $result = mb_convert_encoding($dum,"UTF-8","SJIS");
            return true;
        }catch (Exception $e){
            echo "加工処理に失敗しました。".$e->getMessage();
            echo "<br>もう一度お試しください";
            return false;
        }
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //ファイルの保存先
        $upload = './mosbefore/'.$_FILES['file_upload']['name']; 
        //アップロードが正しく完了したかチェック
        if(move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload)){
            // echo 'アップロード完了';
            image_convert_php($_FILES['file_upload']['name']);
            $_FILES['file_upload'] = "";
        }else{
            echo 'アップロードに失敗しました';
            $_FILES['file_upload'] = "";
        }
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <form action="./index.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
        <div id="drop-zone" style="border: 1px solid; padding: 20px;">
            <p>ファイルをドラッグ＆ドロップもしくは</p>
            <input name="file_upload" type="file" id="file-input"> 
        </div>
        <h2>加工対象の画像</h2>
        <div class="preview" id="preview"></div>

        <!-- <input type="submit" value="アップロード" style="margin-top: 50px"> -->
        <input type="submit" value="変換" style="margin-top: 50px" onclick="setTimeout(imageConvert_js(fileInput.files[0]), 1500);">
    </form>
    
    <div id="php_exec_result"></div>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/main.js"></script>
</body>
</html>