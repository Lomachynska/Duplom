<?php
require_once './utils/uuid.php';

function model_create_message($chat_id, $sender_id, $message)
{
    $connect = db_connect();

    $uuid = generate_uuid();

    $query = "INSERT INTO `messages` (`id`, `chat_id`, `sender_id`, `message`, `created_at`) VALUES ('$uuid', '$chat_id', '$sender_id', '$message', NOW())";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($connect);
    }

    return $result;
}

function model_get_messages_by_chat($chat_id)
{
    $connect = db_connect();

    $query = "SELECT messages.*, users.name, users.lastName, users.avatar FROM `messages` 
              LEFT JOIN `users` ON messages.sender_id = users.id 
              WHERE `chat_id` = '$chat_id' ORDER BY `created_at` ASC";
    $result = mysqli_query($connect, $query);

    $messages = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
    }

    return $messages;
}
?>