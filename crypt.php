<?php
    $key = "秘密鍵";

    function encrypt($plain){
        return openssl_encrypt($plain_text, 'AES-128-ECB', $key);
    }

    function decrypt($file_name){
        return openssl_decrypt($file_name, 'AES-128-ECB', $key);
    }

// /**
//   * 暗号化・復号化クラス
//   **/
// class EncryptionUtil{

//     /*======================================================*
//      * 暗号化用初期値設定                                   *
//      *======================================================*/
//     // エンコードタイプ [AES or DES or BASE64]
//     private $encType;
//     public function EncType($encType){
//         $this->encType = $encType;
//     }

//     // 暗号化キー
//     private $encKey;
//     public function encKey($encKey){
//         $this->encKey = $encKey;
//     }

//     // 暗号化アルゴリズム [OpenSSLが対応しているAES or DESのアルゴリズム]
//     private $encAlgorithm;
//     private $encIvSize;
//     public function encAlgorithm($encAlgorithm){
//         $this->encAlgorithm = $encAlgorithm;
//         $this->encIvSize = 0;
//         if($encAlgorithm != NULL){
//             if($encAlgorithm != ''){
//                 $this->encIvSize = openssl_cipher_iv_length($encAlgorithm);
//             }
//         }
//     }

//     // 暗号化初期化ベクトル [NULL=省略 or ランダム生成='' or 初期化ベクトルの文字列]
//     private $encIv;
//     public function encIv($encIv){
//         $this->encIv = $encIv;
//     }

//     // 暗号化結果の変換方法 [0(変換無し) or 1(BASE64) or 2(HEX)]
//     private $encPack;
//     public function encPack($encPack){
//         $this->encPack = $encPack;
//     }

//     // 文字コード変換元・先 [SJIS or UTF-8 or ...]
//     private $convCharsetF;
//     private $convCharsetT;
//     public function ConvCharset($charset_f, $charset_t){
//         $this->convCharsetF = $charset_f;
//         $this->convCharsetT = $charset_t;
//     }


//     /*======================================================*
//      * AES(DES)/CBC/PKCS5Padding･Base64 Encrypter/Decrypter *
//      *======================================================*/
//     /**
//      * Encrypter
//      *
//      * @param  $encStr
//      * @return binary
//      **/
//     public function encrypt($encStr){
//         switch(strtoupper($this->encType)){
//             case "AES":    return $this->encryptStandard($encStr);
//             case "DES":    return $this->encryptStandard($encStr);
//             case "BASE64": return $this->encryptBase64($encStr);
//         }
//     }
//     /**
//      * Decrypter 
//      *
//      * @param  $decStr
//      * @return string
//      **/
//     public function decrypt($decStr){
//         switch(strtoupper($this->encType)){
//             case "AES":    return $this->decryptStandard($decStr);
//             case "DES":    return $this->decryptStandard($decStr);
//             case "BASE64": return $this->decryptBase64($decStr);
//         }
//     }

//     /*======================================================*
//      * AES(DES)/CBC/PKCS5Padding Encrypter                  *
//      *======================================================*/
//     /**
//      * AES/CBC/PKCS5Padding Encrypter
//      *
//      * @param  $str
//      * @return binary
//      **/
//     private function encryptStandard($str){
//         // 文字コード変換 [convCharsetF ==> convCharsetT]
//         if($this->convCharsetF != $this->convCharsetT){
//             if(($this->convCharsetF != '') && ($this->convCharsetT != '')){
//                 $str = mb_convert_encoding($str, $this->convCharsetT, $this->convCharsetF);
//             }
//         }

//         // 初期化ベクトルを作成
//         if($this->encIv != NULL){
//             if($this->encIv == ''){
//                 $iv = openssl_random_pseudo_bytes($this->encIvSize);
//             }else{
//                 $iv = str_pad($this->encIv, $this->encIvSize);
//             }
//         }

//         // 暗号化
//         if($this->encIv == NULL){
//             $encData = openssl_encrypt($str, $this->encAlgorithm, $this->encKey, OPENSSL_RAW_DATA);
//         }else{
//             $encData = openssl_encrypt($str, $this->encAlgorithm, $this->encKey, OPENSSL_RAW_DATA, $iv);
//         }

//         // 暗号化文字列をエンコード
//         switch (strtoupper($this->encPack)){
//         case '0': // 変換無し
//             if($this->encIv == ''){
//                 return $iv.$encData;
//             }else{
//                 return $encData;
//             }
//         case '1': // BASE64
//             if($this->encIv == ''){
//                 return base64_encode($iv.$encData);
//             }else{
//                 return base64_encode($encData);
//             }
//         case '2': // HEX
//             if($this->encIv == ''){
//                 return bin2hex($iv.$encData);
//             }else{
//                 return bin2hex($encData);
//             }
//         default:
//             return '';
//         }
//     }

//     /**
//      * AES/CBC/PKCS5Padding Decrypter
//      *
//      * @param  $str
//      * @return string
//      **/
//     private function decryptStandard($str){
//         // 暗号化文字列のエンコードとデコード
//         switch (strtoupper($this->encPack)){
//         case '0': // 変換無し
//             $data = stripcslashes($str); // エスケープ文字を除去
//             break;
//         case '1': // BASE64
//             $data = base64_decode($str);
//             break;
//         case '2': // HEX
//             $data = $this->hex2bin($str);
//             break;
//         default:
//             return '';
//         }

//         // 初期化ベクトルを取得
//         if($this->encIv != NULL){
//             if($this->encIv == ''){
//                 $iv   = substr($data, 0, $this->encIvSize);
//                 $data = substr($data, $this->encIvSize);
//             }else{
//                 $iv = str_pad($this->encIv, $this->encIvSize);
//             }
//         }

//         // デコード
//         if($this->encIv == NULL){
//             $encData = openssl_decrypt($data, $this->encAlgorithm, $this->encKey, OPENSSL_RAW_DATA);
//         }else{
//             $encData = openssl_decrypt($data, $this->encAlgorithm, $this->encKey, OPENSSL_RAW_DATA, $iv);
//         }

//         // 文字コード変換 [convCharsetT ==> convCharsetF]
//         if($this->convCharsetF != $this->convCharsetT){
//             if(($this->convCharsetF != '') && ($this->convCharsetT != '')){
//                 $encData = mb_convert_encoding($encData, $this->convCharsetF, $this->convCharsetT);
//             }
//         }

//         return $encData;
//     }

//     /**
//      * 16進文字列をバイナリーデータに変換
//      *
//      * @param  $str
//      * @return binary
//      **/
//     private function hex2bin($str){
//         if(!isset($str)) return null;

//         // 16進文字列をバイナリーデータに変換
//         $ret = '';
//         for ($i = 0; $i < strlen($str); $i += 2){
//             $ret .= chr(hexdec($str{$i}.$str{($i+1)}));
//         }

//         return $ret;
//     }

//     /*======================================================*
//      * Base64                                               *
//      *======================================================*/
//     /**
//      * Base64 Encrypter
//      *
//      * @param  $str
//      * @return string
//      **/
//     private function encryptBase64($str){
//         // $strが暗号化されていない場合のみ文字コードを変換する
//         if (strtoupper($this->encType) == "BASE64") {
//             // 文字コード変換 [convCharsetF ==> convCharsetT]
//             if($this->convCharsetF != $this->convCharsetT){
//                 if(($this->convCharsetF != '') && ($this->convCharsetT != '')){
//                     $str = mb_convert_encoding($str, $this->convCharsetT, $this->convCharsetF);
//                 }
//             }
//         }

//         // エンコード
//         return base64_encode($str);
//     }

//     /**
//      * Base64 Decrypter
//      *
//      * @param  $str
//      * @return string
//      **/
//     private function decryptBase64($str){
//         // デコード
//         $decStr = base64_decode($str);

//         // $strが暗号化されていないのみ文字コードを変換する
//         if (strtoupper($this->encType) == "BASE64") {
//             // 文字コード変換 [convCharsetT ==> convCharsetF]
//             if($this->convCharsetF != $this->convCharsetT){
//                 if(($this->convCharsetF != '') && ($this->convCharsetT != '')){
//                     $decStr = mb_convert_encoding($decStr, $this->convCharsetF, $this->convCharsetT);
//                 }
//             }
//         }
//        return $decStr;
//     }
// }
?>