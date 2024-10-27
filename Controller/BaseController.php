<?php
class BaseController{
    protected $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    function validate($str) {
        return trim(htmlspecialchars($str));
      }

    function filterEmail($str){
        if(!filter_var($str, FILTER_VALIDATE_EMAIL)){
            $errorEmail ='Invalid Email';
        }
        else{
            $errorEmail='';
        }
        return $errorEmail;
    }

    function filterPass($str){
        if(strlen($str)<6){
        //     echo 'Your Password is Too short';
        // }
            $passwordError='Your Password is Too short';
        }
        elseif(empty($str)){
            $passwordError='Your Password Should Not be empty';
        }
        else{
            $passwordError='';
        }
    return $passwordError;
    }

    function filterName($str){
        if(empty($str)){
            $nameError='Name should not be empty';
        }
        elseif(preg_match('/[a-zA-Z0-9\s]+$/', $str)==0){
            $nameError = 'Name can only contain letters, numbers and white spaces';
        }
        else{
            $nameError='';
        }
        return $nameError;
    }

}