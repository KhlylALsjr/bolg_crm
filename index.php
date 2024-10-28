<?php
require_once 'app/model/user.php';
require_once 'app/model/post.php';
require_once 'app/controller/LoginController.php';
require_once 'app/controller/PostController.php';
require_once 'config/Database.php';

define('BASE_PATH', '/php/blog_mvc/');

// بدء الجلسة
session_start();

// إنشاء اتصال بقاعدة البيانات
$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// تمرير الاتصال إلى PostController و LoginController
$loginController = new LoginController($conn);
$postController = new PostController($conn);

$action = $_SERVER['REQUEST_URI'];

// التحقق من الجلسة لتحديد صفحة تسجيل الدخول أو الصفحة المطلوبة
if (!isset($_SESSION['user-id'])) {
    $loginController->index();
} else {
    switch (true) {
        case $action === BASE_PATH:
            $loginController->index();
            break;
        case $action === BASE_PATH . 'Signup':
            $loginController->register();
            break;
        case $action === BASE_PATH . 'Dashboard':
            $loginController->dashboard();
            break;
        case $action === BASE_PATH . 'logout':
            $loginController->logout();
            break;
        case strpos($action, BASE_PATH . 'edit/') === 0:
            $loginController->edit();
            break;
        case strpos($action, BASE_PATH . 'delete/') === 0:
            $loginController->delete();
            break;
        case $action === BASE_PATH . 'Posts':
            $postController->index();
            break;
        case $action === BASE_PATH . 'Posts/create':
            $postController->create();
            break;
        case strpos($action, BASE_PATH . 'Posts/edit') === 0:
            $postController->edit();
            break;
        case strpos($action, BASE_PATH . 'Posts/delete') === 0:
            $postController->delete();
            break;
        default:
            $loginController->index();
            break;
    }
}
