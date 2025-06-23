<?php
require_once './utils/uuid.php';

function model_create_review($user_id, $order_id, $information)
{
    $connect = db_connect();

    $uuid = generate_uuid();

    $query = "INSERT INTO `reviews` (`id`, `user_id`, `order_id`, `information`, `created_at`) VALUES ('$uuid', '$user_id', '$order_id', '$information', NOW())";
    $result = mysqli_query($connect, $query);

    return $result;
}

function model_get_reviews_by_order($order_id)
{
    $connect = db_connect();

    $query = "SELECT reviews.*, users.name, users.lastName FROM `reviews` JOIN `users` ON reviews.user_id = users.id WHERE `order_id` = '$order_id'";
    $result = mysqli_query($connect, $query);

    $reviews = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
    }

    return $reviews;
}
?>