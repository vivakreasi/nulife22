<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;

class Statik extends Model {
    
    public function getValidationCreateUser($data){
        $validator = Validator::make(
            array(
                'Fullname'        => $data->fullname, 
                'Email'              => $data->email,
                'HP'                   => $data->hp,
                'Password'        => $data->password
            ),
            array(
                'Fullname'   => 'required|max:50|regex:/^[a-zA-Z0-9_ -]+$/',
                'Email'         => 'required|email|max:60',
                'HP'              => 'required|regex:/^[0-9]+$/|min:10|max:13',
                'Password'  => 'required|min:6'
            ),
            array(
                'Fullname.required' => 'Full name must not be empty',
                'Fullname.max' => 'Full name maximum :max character',
                'Fullname.regex' => 'Full name must be alphanumeric character and white space',
                
                'Email.required' => 'Email must not be empty',
                'Email.email' => 'Email must be alphanumeric character and white space',
                'Email.max' => 'Maximum Email :max character',
                
                'HP.required' => 'Mobile Phone must not be empty',
                'HP.regex' => 'Mobile Phone must be numeric character',
                'HP.min' => 'Minimum Mobile Phone :min character',
                'HP.max' => 'Maximum Mobile Phone :max character',

                'Password.required' => 'Password must not be empty',
                'Password.min' => 'Password minimum :min character',
            )
        );
        return $validator;
    }
    
    public function getValidationLostPassword($data){
        $validator = Validator::make(
            array('Email'              => $data->email),
            array('Email'         => 'required|email|max:60'),
            array(
                'Email.required' => 'Email must not be empty',
                'Email.email' => 'Email must be alphanumeric character and white space',
                'Email.max' => 'Maximum Email :max character',
            )
        );
        return $validator;
    }
    
    public function getValidationPassword($data){
        $validator = Validator::make(
            array('Password'        => $data->password),
            array('Password'         => 'required|min:6'),
            array(
                'Password.required' => 'Password must not be empty',
                'Password.min' => 'Password minimum :min character',
            )
        );
        return $validator;
    }
    
    public function generateKey() {
        $charsetnumber = "0123456789";
        $key_number = '';
        for ($i = 0; $i < 5; $i++) {
            $key_number .= $charsetnumber[(mt_rand(0, strlen($charsetnumber) - 1))];
        }
        $charset = $key_number;
        $key = str_shuffle($charset);
        return $key;
    }
    
    public function salt() {
        $salt = 'nuLife2017z1no17';
        return $salt;
    }    
    
    public  function _b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
    
     public  function getEncode($value){ 
        if(!$value){return false;}
        $charsetnumber = "123456789abcdefghijklmnopqrstuvwxyz";
        $key_number = '';
        for ($i = 0; $i < 4; $i++) {
            $key_number .= $charsetnumber[(mt_rand(0, strlen($charsetnumber) - 1))];
        }
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, Statik::salt(), $text.$key_number, MCRYPT_MODE_ECB, $iv);
        $enc = trim(Statik::_b64encode($crypttext)); 
        return $enc;
    }
    
    public function _b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
    
    public function getDecode($value){
        if(!$value){return false;}
        $crypttext = Statik::_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, Statik::salt(), $crypttext, MCRYPT_MODE_ECB, $iv);
        $dec = substr(trim($decrypttext), 0, -4);
        return $dec;
    }
    
    public function getValidationFullname($data){
        $validator = Validator::make(
            array('Fullname' => $data->fullname),
            array('Fullname' => 'required|max:50|regex:/^[a-zA-Z0-9_ -]+$/'),
            array(
                'Fullname.required' => 'Full name must not be empty',
                'Fullname.max' => 'Full name maximum :max character',
                'Fullname.regex' => 'Full name must be alphanumeric character and white space'
            )
        );
        return $validator;
    }
    
    public function getValidationEmail($data){
        $validator = Validator::make(
            array('Email' => $data->email),
            array('Email' => 'required|email|max:60'),
            array(
                'Email.required' => 'Email must not be empty',
                'Email.email' => 'Email must be alphanumeric character and white space',
                'Email.max' => 'Maximum Email :max character'
            )
        );
        return $validator;
    }
    
    
    
    
}

