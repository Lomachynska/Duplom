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

        $result = model_create_order($user_id, $truckType, $weight, $size, $description, $start_point, $end_point, $price, $distance);

        if ($result) {
            header("Location: /account/dashboard");
            exit;
        } else {
            echo 'Failed to create order: ' . $result;
        }
    }
    require_once './views/create-order.php';
}
function dashboard()
{
    $filters = [
        'weight' => $_GET['weight'] ?? null,
        'truck_type' => $_GET['truck_type'] ?? null,
        'size' => $_GET['size'] ?? null,
    ];

    $orders = model_get_all_orders($filters);
    require_once './views/dashboard.php';
}
