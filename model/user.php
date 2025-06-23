<?php
require_once './utils/uuid.php';

function model_register($name, $lastName, $phone, $email, $password, $account_type)
{
    $connect = db_connect();

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");
    if (mysqli_num_rows($check_user) > 0) {
        return false;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $uuid = generate_uuid();

    $insert_user = mysqli_query($connect, "INSERT INTO `users` (`id`, `name`, `lastName`, `phone`, `email`, `password`, `role`, `information`, `banned`) VALUES ('$uuid', '$name', '$lastName', '$phone', '$email', '$hashed_password', '$account_type', '', false)");

    return $insert_user;
}

function model_login($phone, $password)
{
    $connect = db_connect();

    $query = "SELECT * FROM `users` WHERE `phone` = '$phone'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user['banned']) {
            return 'banned';
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        } else {
            return 'invalid_password';
        }
    } else {
        return 'invalid_phone';
    }
}

function info_user($id)
{
    $connect = db_connect();

    $id = mysqli_real_escape_string($connect, $id);

    $user_all = mysqli_query($connect, "SELECT * FROM `users` WHERE id = '$id'");
    if ($user_all && mysqli_num_rows($user_all) > 0) {
        $user_info = mysqli_fetch_assoc($user_all);
        return $user_info;
    } else {
        return null;
    }
}

function model_edit_user($name, $lastName, $phone, $email, $information, $password = null, $photo_path = null)
{
    $connect = db_connect();

    $id = $_SESSION['user_id'];
    $id = mysqli_real_escape_string($connect, $id);

    // Формуємо базовий SQL-запит
    $query = "UPDATE `users` SET `name` = '$name', `lastName` = '$lastName', `phone` = '$phone', `email` = '$email', `information` = '$information'";

    // Додаємо оновлення пароля, якщо він переданий
    if ($password != null) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", `password` = '$hashed_password'";
    }

    // Додаємо оновлення фото, якщо шлях до нього переданий
    if ($photo_path != null) {
        $query .= ", `avatar` = '$photo_path'";
    }

    // Завершуємо запит
    $query .= " WHERE `id` = '$id'";

    // Виконуємо запит
    $result = mysqli_query($connect, $query);

    return $result;
}



function model_get_all_users()
{
    $connect = db_connect();

    $query = "SELECT * FROM `users` WHERE `role` != 'admin'";
    $result = mysqli_query($connect, $query);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}


function userBanned($user_id)
{
    $connect = db_connect();
    $user_id = mysqli_real_escape_string($connect, $user_id);

    // Отримуємо поточний статус користувача
    $query = "SELECT `banned` FROM `users` WHERE `id` = '$user_id'";
    $result = mysqli_query($connect, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Змінюємо статус на протилежний
        $new_status = $user['banned'] ? 0 : 1;
        $query = "UPDATE `users` SET `banned` = '$new_status' WHERE `id` = '$user_id'";
        return mysqli_query($connect, $query);
    }

    return false;
}