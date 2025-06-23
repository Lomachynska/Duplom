<?php
require_once './utils/uuid.php';

function model_create_chat($user_id_1, $user_id_2)
{
    $connect = db_connect();

    $uuid = generate_uuid();

    $query = "INSERT INTO `chats` (`id`, `user_id_1`, `user_id_2`, `created_at`) VALUES ('$uuid', '$user_id_1', '$user_id_2', NOW())";
    $result = mysqli_query($connect, $query);

    // if (!$result) {
    //     echo "Error: " . mysqli_error($connect);
    // }

    return $result;
}

function model_get_user_chats($user_id)
{
    $connect = db_connect();


    $query = "SELECT chats.*, 
                         u1.name AS user1_name, u1.lastName AS user1_lastName, u1.avatar AS user1_avatar, 
                         u2.name AS user2_name, u2.lastName AS user2_lastName, u2.avatar AS user2_avatar 
                  FROM `chats` 
                  LEFT JOIN `users` u1 ON chats.user_id_1 = u1.id 
                  LEFT JOIN `users` u2 ON chats.user_id_2 = u2.id 
                  WHERE `user_id_1` = '$user_id' OR `user_id_2` = '$user_id'";
    $result = mysqli_query($connect, $query);

    $chats = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $chats[] = $row;
        }
    }

    return $chats;
}
?>