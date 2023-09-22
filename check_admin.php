<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if(isset($_SESSION['user_admin'])){
    if ($_SESSION['user_admin'] != true && $_SESSION['user_admin'] != 1) {
        header("location:./index.php");
        http_response_code(404);
        exit();
    }
}else{
    header("location:./admin.php");
    http_response_code(404);
    exit();
}
?>