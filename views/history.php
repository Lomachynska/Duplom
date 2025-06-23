<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroDrop</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php' ?>

            <div class="crm__content">
                <div class="table">

                    <div class="crm__header">
                        <h5>Замовлення</h5>
                    </div>

                    <form class="form form--filter" action="" method="GET">
                        <div class="form__list">
                            <div class="form__item">
                                <label for="weight_from">Вага</label>
                                <input type="number" id="weight_from" name="weight_from" placeholder="від"
                                    value="<?= htmlspecialchars($_GET['weight_from'] ?? '') ?>">
                            </div>
                            <div class="form__item">
                                <input type="number" id="weight_to" name="weight_to" placeholder="до"
                                    value="<?= htmlspecialchars($_GET['weight_to'] ?? '') ?>">
                            </div>

                            <div class="form__item">
                                <label for="truck_type">Тип посилки</label>
                                <select name="truck_type" id="">
                                    <option value="">Все</option>
                                    <option value="clothing" <?= (isset($_GET['truck_type']) && $_GET['truck_type'] == 'clothing') ? 'selected' : '' ?>>Clothing</option>
                                    <option value="food" <?= (isset($_GET['truck_type']) && $_GET['truck_type'] == 'food') ? 'selected' : '' ?>>Food</option>
                                    <option value="electronics" <?= (isset($_GET['truck_type']) && $_GET['truck_type'] == 'electronics') ? 'selected' : '' ?>>Electronics</option>
                                    <option value="furniture" <?= (isset($_GET['truck_type']) && $_GET['truck_type'] == 'furniture') ? 'selected' : '' ?>>Furniture</option>
                                    <option value="books" <?= (isset($_GET['truck_type']) && $_GET['truck_type'] == 'books') ? 'selected' : '' ?>>Books</option>
                                </select>
                            </div>
                            <div class="form__item">
                                <label for="size">Розмір посилки</label>

                                <select name="size" id="">
                                    <option value="">Все</option>
                                    <option value="sm" <?= (isset($_GET['size']) && $_GET['size'] == 'sm') ? 'selected' : '' ?>>до 20см.</option>
                                    <option value="lg" <?= (isset($_GET['size']) && $_GET['size'] == 'lg') ? 'selected' : '' ?>>до 80см.</option>
                                    <option value="xl" <?= (isset($_GET['size']) && $_GET['size'] == 'xl') ? 'selected' : '' ?>>до 160 см.</option>
                                </select>
                            </div>

                            <div class="form__item">
                                <label for="date">Дата</label>
                                <input type="date" name="date" placeholder="від"
                                    value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
                            </div>
                        </div>

                        <button class="btn btn-outline btn-no-round">Застосувати</button>
                    </form>

                    <div class="table__list">
                        <?php foreach ($orders as $index => $order): ?>
                            <a href="/order?order_id=<?= $order['id'] ?>" class="table__item">
                                <div class="table__main">
                                    <div class="table__main-info">
                                      
                                        <p>№<?= $index + 1 ?> | <?= htmlspecialchars($order['truck_type']) ?></p>
                                        <span><?= htmlspecialchars($order['description']) ?></span>
                                    </div>
                                </div>
                                <div class="table__date">
                                    <span><?= htmlspecialchars($order['created_at']) ?></span>
                                    <?php if ($order['status'] == 'pending'): ?>
                                        <div class="table__main-status btn btn-primary btn-sm">
                                            В обробці
                                        </div>
                                    <?php elseif ($order['status'] == 'completed'): ?>
                                        <div class="table__main-status btn btn-success btn-sm">
                                            Доставлено
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

        </main>

    </div>
</body>

</html>