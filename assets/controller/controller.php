<?php


function main()
{
    require_once './views/home.php';
}

function about()
{
    require_once './views/about.php';
}

function bpla()
{
    require_once './views/bpla.php';
}

function statistics(){
    $orders = model_get_all_orders('');
    
    // Функція для отримання статистики за період
    function getStatistics($orders, $period) {
        $now = new DateTime();
        $stats = [
            'orders' => 0,
            'earnings' => 0,
            'distance' => 0,
            'change' => [
                'orders' => 0,
                'earnings' => 0,
                'distance' => 0
            ]
        ];

        // Визначаємо початок періоду
        switch($period) {
            case 'day':
                $start = (clone $now)->setTime(0, 0, 0);
                $prevStart = (clone $now)->modify('-1 day')->setTime(0, 0, 0);
                $prevEnd = (clone $now)->modify('-1 day')->setTime(23, 59, 59);
                break;
            case 'week':
                $start = (clone $now)->modify('-7 days')->setTime(0, 0, 0);
                $prevStart = (clone $now)->modify('-14 days')->setTime(0, 0, 0);
                $prevEnd = (clone $now)->modify('-8 days')->setTime(23, 59, 59);
                break;
            case 'month':
                $start = (clone $now)->modify('-30 days')->setTime(0, 0, 0);
                $prevStart = (clone $now)->modify('-60 days')->setTime(0, 0, 0);
                $prevEnd = (clone $now)->modify('-31 days')->setTime(23, 59, 59);
                break;
        }

        // Поточний період
        $currentOrders = 0;
        $currentEarnings = 0;
        $currentDistance = 0;

        // Попередній період
        $prevOrders = 0;
        $prevEarnings = 0;
        $prevDistance = 0;

        foreach ($orders as $order) {
            $orderDate = new DateTime($order['created_at']);
            
            // Для поточного періоду
            if ($orderDate >= $start && $orderDate <= $now) {
                $currentOrders++;
                $currentEarnings += floatval($order['price']);
                $currentDistance += floatval($order['distance']);
            }
            
            // Для попереднього періоду
            if ($orderDate >= $prevStart && $orderDate <= $prevEnd) {
                $prevOrders++;
                $prevEarnings += floatval($order['price']);
                $prevDistance += floatval($order['distance']);
            }
        }

        // Розраховуємо відсотки змін
        $stats['orders'] = $currentOrders;
        $stats['earnings'] = $currentEarnings;
        $stats['distance'] = round($currentDistance, 2);

        if ($prevOrders > 0) {
            $stats['change']['orders'] = round(($currentOrders - $prevOrders) / $prevOrders * 100);
        }
        if ($prevEarnings > 0) {
            $stats['change']['earnings'] = round(($currentEarnings - $prevEarnings) / $prevEarnings * 100);
        }
        if ($prevDistance > 0) {
            $stats['change']['distance'] = round(($currentDistance - $prevDistance) / $prevDistance * 100);
        }

        return $stats;
    }

    // Отримуємо статистику за всі періоди
    $statistics = [
        'day' => getStatistics($orders, 'day'),
        'week' => getStatistics($orders, 'week'),
        'month' => getStatistics($orders, 'month')
    ];

    require_once './views/statistic.php';
}

function settings()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $lastName = $_POST['last-name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $information = $_POST['information'];
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        $photo = $_FILES['photo'];
        $photo_path = null;

        // Перевірка та завантаження фото
        if (isset($photo) && $photo['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/users/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); // Створюємо папку, якщо її немає
            }

            $unique_name = uniqid() . '_' . basename($photo['name']);
            $target_file = $target_dir . $unique_name;

            if (move_uploaded_file($photo['tmp_name'], $target_file)) {
                $photo_path = $target_file; // Зберігаємо шлях до завантаженого фото
            } else {
                echo "Помилка завантаження файлу.";
            }
        }

        // Виклик моделі для оновлення даних
        $result = model_edit_user($name, $lastName, $phone, $email, $information, $password, $photo_path);

        if ($result) {
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        }
    }

    $id = $_SESSION['user_id'];
    $info = info_user($id);

    require_once './views/settings.php';
}
function signin()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $result = model_login($phone, $password);

        if ($result === true) {
            header("Location: /account/settings");
            exit;
        } elseif ($result === 'banned') {
            $error_message = "Your account is banned.";
        } elseif ($result === 'invalid_password') {
            $error_message = "Invalid password.";
        } elseif ($result === 'invalid_phone') {
            $error_message = "Invalid phone number.";
        }
    }
    require_once './views/sign-in.php';
}


function signup()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $lastName = $_POST['last-name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $account_type = $_POST['account_type'];

        $result = model_register($name, $lastName, $phone, $email, $password, $account_type);

        if ($result) {
            header("Location: /sign-in");
            exit;
        }
    }
    require_once './views/sign-up.php';
}

function create_order()
{


    if (!isset($_SESSION['user_id'])) {
        header("Location: /sign-in");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_SESSION['user_id'];
        $truckType = $_POST['truck_type'];
        $weight = $_POST['weight'];
        $size = $_POST['size'];
        $description = $_POST['description'];
        $start_point = $_POST['start_point'];
        $end_point = $_POST['end_point'];
        $price = $_POST['price'];
        $distance = $_POST['distance'];
        $time = $_POST['time'];
        $recognition = $_POST['recognition'];
        $delivery_instructions = $_POST['delivery_instructions'];

        $result = model_create_order($user_id, $truckType, $weight, $size, $description, $start_point, $end_point, $price, $distance, $time, $recognition, $delivery_instructions);

        if ($result) {
            header("Location: /account/history");
            exit;
        } else {
            echo 'Failed to create order: ' . $result;
        }
    }
    require_once './views/create-order.php';
}
function history()
{
    $filters = [
        'weight_from' => $_GET['weight_from'] ?? null,
        'weight_to' => $_GET['weight_to'] ?? null,
        'truck_type' => $_GET['truck_type'] ?? null,
        'size' => $_GET['size'] ?? null,
        'date' => $_GET['date'] ?? null,
    ];

    $orders = model_get_all_orders($filters);
    require_once './views/history.php';
}


function chat()
{
    $user_id = $_SESSION['user_id'];
    $chat_id = $_GET['chat_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: /sign-in");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = $_POST['message'];

        $result = model_create_message($chat_id, $user_id, $message);
        if ($result) {
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        }

    }

    $messages = model_get_messages_by_chat($chat_id);
    // var_dump($messages);

    $chats = model_get_user_chats($user_id);
    require_once './views/chat.php';
}







function order()
{


    if (!isset($_SESSION['user_id'])) {
        header("Location: /sign-in");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['information'])) {
            $user_id = $_SESSION['user_id'];
            $order_id = $_POST['order_id'];
            $information = $_POST['information'];

            $result = model_create_review($user_id, $order_id, $information);

            if ($result) {
                header("Location: /order?order_id=$order_id");
                exit;
            } else {
                echo 'Failed to add review.';
            }
        } elseif (isset($_POST['executor_id'])) {
            $order_id = $_POST['order_id'];
            $executor_id = $_POST['executor_id'];

            $result = model_assign_executor($order_id, $executor_id);

            if ($result) {
                // Створення чату між замовником і виконавцем
                $order = model_get_order_by_id($order_id);
                $customer_id = $order['user_id'];
                model_create_chat($customer_id, $executor_id);

                header("Location: /order?order_id=$order_id");
                exit;
            } else {
                echo 'Failed to assign executor.';
            }
        } elseif (isset($_POST['complete_order'])) {
            $order_id = $_POST['order_id'];
            $complete_order = $_POST['complete_order'];

            $result = model_complete_order($order_id, $complete_order);

            if ($result) {
                header("Location: /order?order_id=$order_id");
                exit;
            } else {
                echo 'Failed to complete order.';
            }
        }
    }

    $order_id = $_GET['order_id'];
    $order = model_get_order_by_id($order_id);
    $reviews = model_get_reviews_by_order($order_id);
    $user_id = $_SESSION['user_id'];
    $user_reviewed = false;

    foreach ($reviews as $review) {
        if ($review['user_id'] == $user_id) {
            $user_reviewed = true;
            break;
        }
    }

    if ($order === null) {
        echo 'Order not found';
        return;
    }

    require_once './views/order.php';
}

// ...existing code...


function adminUsers()
{
    $users = model_get_all_users();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];
        $result = userBanned($user_id);

        if ($result) {
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            echo 'Failed to update user status.';
        }
    }

    require_once './views/admin/users.php';
}

function adminProjects()
{
    $projects = model_get_all_orders('');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $project_id = $_POST['project_id'];
        $result = projectBanned($project_id);

        if ($result) {
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            echo 'Failed to update user status.';
        }
    }

    require_once './views/admin/projects.php';
}

function instructionController()
{
    require_once './views/instruction.php';
}

function adminMaps()
{
    require_once './views/admin/maps.php';
}
function logout()
{
    session_destroy();
    header('Location: /');
    exit;
}

function mapsController(){
    require_once './views/maps.php';
}

function droneStatistics(){
    require_once './views/drone-statistics.php';
}

function not_found()
{
    echo 'Такої сторінки не існує';
}

