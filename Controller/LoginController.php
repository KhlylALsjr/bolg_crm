<?php

require_once 'app/Model/User.php';
require_once 'BaseController.php';
// تأكد من أن هذا المسار صحيح ويؤدي إلى الملف المطلوب
require 'view/user/login.php';



class LoginController extends BaseController{

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $emailError = $this->filterEmail($this->validate($_POST['email']));
            $passwordError = $this->filterPass($this->validate($_POST['pass']));
    
            if (empty($emailError) && empty($passwordError)) {
                $user->setEmail($this->validate($_POST['email']));
                $user->setPass($this->validate($_POST['pass']));
                $res = $user->login($this->conn);
    
                if ($res) {
                    if ($_SESSION['user-type'] == 'Admin') {
                        header('Location: /php/blog_mvc/Dashboard');
                        exit;
                    } else {
                        header('Location: /php/blog_mvc');
                        exit;
                    }
                }
            } else {
                // عرض أخطاء تسجيل الدخول
                echo $emailError;
                echo $passwordError;
            }
        } 
        // else {
        //     require 'view/user/login.php';
        // }
    }
    

    public function register(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user=new User();
            $nameError=$this->filterName($this->validate($_POST['username']));
            $emailError=$this->filterEmail($this->validate($_POST['email']));
            $passwordError=$this->filterPass($this->validate($_POST['pass']));
            if(empty($nameError) && empty($emailError) && empty($passwordError)){
                $user->setName($this->validate($_POST['username']));
                $user->setEmail($this->validate($_POST['email']));
                $user->setPass($this->validate($_POST['pass']));
                $user->save($this->conn);
                header('Location: /php/blog_mvc/');
                exit;
            }
            else{
                require 'view/user/signup.php';
            }
        }
        else{
            require 'view/user/signup.php';
        }
    }

    public function dashboard(){
        $users=User::getAllUsers($this->conn);
        require __DIR__ . '/../../view/user/dashboard.php';
    }

    public function edit(){
        if(isset($_POST['check'])){
            $id = $_POST['id'];
            $user = User::getUserById($this->conn, $id);
            $user->setType($_POST['check']);
            $user->save($this->conn);
            header('Location: /php/blog_mvc/Dashboard');
            exit;
        }
        else{
            $id=$_GET['id'];
            $user = User::getUserById($this->conn, $id);
            require 'view/user/edit.php';
        }
    }

    public function delete(){
        if(isset($_POST['yes'])){
            $id=$_POST['id'];
            $user = User::getUserById($this->conn, $id);
            $user->delete($this->conn);
            header('Location: /php/blog_mvc/Dashboard');
            exit;
        }
        elseif (isset($_POST['no'])){
            header('Location: /php/blog_mvc/Dashboard');
            exit;
        }
        else{
            $id=$_GET['id'];
            $user = User::getUserById($this->conn, $id);
            require 'view/user/delete.php';
        }
    }

    public function logout(){
        $user=new User();
        $user->Signout();
        header('location:/php/blog_mvc/');
        exit;
    }

    
}
