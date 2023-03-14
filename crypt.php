<?php
    $key = "秘密鍵";

    function encrypt($plain){
        return openssl_encrypt($plain_text, 'AES-128-ECB', $key);
    }

    function decrypt($file_name){
        return openssl_decrypt($file_name, 'AES-128-ECB', $key);
    }

?>
