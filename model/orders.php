<?php
require_once './utils/uuid.php';

function model_create_order($user_id, $truckType, $weight, $size, $description, $start_point, $end_point, $price, $distance, $time, $recognition, $delivery_instructions)
{
    $connect = db_connect();

    $uuid = generate_uuid();

    $query = "INSERT INTO `orders` (`id`, `user_id`, `executor_id`, `truck_type`, `weight`, `size`, `description`, `start_point`, `end_point`, `status`,`price`,`distance`,`time`,`recognition`,`delivery_instructions`) VALUES ('$uuid', '$user_id',NULL, '$truckType', '$weight', '$size', '$description', '$start_point', '$end_point', 'pending','$price','$distance', '$time','$recognition','$delivery_instructions')";
    $result = mysqli_query($connect, $query);

    return $result;
}

function model_get_orders_by_user($user_id)
{
    $connect = db_connect();

    $query = "SELECT * FROM `orders` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($connect, $query);

    $orders = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    }

    return $orders;
}


function model_get_all_orders($filters)
{
    $connect = db_connect();
    
    // Перевіряємо наявність користувача в сесії
    if (!isset($_SESSION['user_id'])) {
        return [];
    }
    
    $user_id = mysqli_real_escape_string($connect, $_SESSION['user_id']);
    
    // Базовий запит
    $query = "SELECT * FROM `orders`";
    
    // Якщо користувач не executor, показуємо тільки його замовлення
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'executor') {
        $query .= " WHERE `user_id` = '$user_id'";
    }

    // Filter by weight range
    if (!empty($filters['weight_from'])) {
        $weight_from = mysqli_real_escape_string($connect, $filters['weight_from']);
        $query .= (strpos($query, 'WHERE') !== false ? " AND" : " WHERE") . " `weight` >= '$weight_from'";
    }

    if (!empty($filters['weight_to'])) {
        $weight_to = mysqli_real_escape_string($connect, $filters['weight_to']);
        $query .= (strpos($query, 'WHERE') !== false ? " AND" : " WHERE") . " `weight` <= '$weight_to'";
    }

    // Filter by truck type
    if (!empty($filters['truck_type'])) {
        $truck_type = mysqli_real_escape_string($connect, $filters['truck_type']);
        $query .= (strpos($query, 'WHERE') !== false ? " AND" : " WHERE") . " `truck_type` = '$truck_type'";
    }

    // Filter by size
    if (!empty($filters['size'])) {
        $size = mysqli_real_escape_string($connect, $filters['size']);
        $query .= (strpos($query, 'WHERE') !== false ? " AND" : " WHERE") . " `size` = '$size'";
    }

    // Filter by date
    if (!empty($filters['date'])) {
        $date = mysqli_real_escape_string($connect, $filters['date']);
        $query .= (strpos($query, 'WHERE') !== false ? " AND" : " WHERE") . " DATE(STR_TO_DATE(`time`, '%Y-%m-%dT%H:%i')) = '$date'";
    }

    // Order by creation date, newest first
    $query .= " ORDER BY created_at DESC";

    $result = mysqli_query($connect, $query);

    if (!$result) {
        // Handle query error
        return [];
    }

    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

    mysqli_close($connect);
    return $orders;
}

function model_get_order_by_id($order_id)
{
    $connect = db_connect();

    $query = "SELECT * FROM `orders` WHERE `id` = '$order_id'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

function model_assign_executor($order_id, $executor_id)
{
    $connect = db_connect();

    $query = "UPDATE `orders` SET `executor_id` = '$executor_id', `status` = 'in_progress' WHERE `id` = '$order_id'";
    $result = mysqli_query($connect, $query);

    return $result;
}

function model_complete_order($order_id, $complete_order)
{
    $connect = db_connect();

    $query = "UPDATE `orders` SET `status` = '$complete_order' WHERE `id` = '$order_id'";
    $result = mysqli_query($connect, $query);

    return $result;
}

function projectBanned($project_id)
{
    $connect = db_connect();
    $project_id = mysqli_real_escape_string($connect, $project_id);

    // Отримуємо поточний статус користувача
    $query = "SELECT `banned` FROM `orders` WHERE `id` = '$project_id'";
    $result = mysqli_query($connect, $query);
    $project = mysqli_fetch_assoc($result);

    if ($project) {
        // Змінюємо статус на протилежний
        $new_status = $project['banned'] ? 0 : 1;
        $query = "UPDATE `orders` SET `banned` = '$new_status' WHERE `id` = '$project_id'";
        return mysqli_query($connect, $query);
    }

    return false;
}

?>