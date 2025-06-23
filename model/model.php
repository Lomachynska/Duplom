<?php
function db_connect()
{
    // $connect = mysqli_connect('localhost', 'root', 'root', 'aerodrop');
    $connect = mysqli_connect('yk576273.mysql.tools', 'yk576273_aerodrop', '^33%mH9Dnt', 'yk576273_aerodrop');
    if (!$connect) {
        return 'Помилка підключення до бази даних';
    } else {
        return $connect;
    }
}


require_once './model/user.php';
require_once './model/orders.php';
require_once './model/reviews.php';
require_once './model/chat.php';
require_once './model/message.php';
?>