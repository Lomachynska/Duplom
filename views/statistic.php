<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="icon" href="/assets/img/logo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 1.1em;
            color: #666;
        }

        .stat-period {
            font-size: 0.9em;
            color: #999;
        }

        .stat-value {
            font-size: 1.8em;
            font-weight: bold;
            margin: 10px 0;
        }

        .stat-change {
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-change.positive {
            color: #4CAF50;
        }

        .stat-change.negative {
            color: #f44336;
        }

        .stat-icon {
            font-size: 1.5em;
            margin-right: 10px;
        }

        .orders-icon { color: #2196F3; }
        .earnings-icon { color: #4CAF50; }
        .distance-icon { color: #FF9800; }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php require_once './templates/header.php'; ?>

        <main class="crm">
            <?php require_once './templates/sidebar.php' ?>

            <div class="crm__content">
             

                <div class="crm__header">
                    <h5>Статистика</h5>
                </div>

                <div class="statistics-grid">
                    <!-- Замовлення -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-shopping-cart stat-icon orders-icon"></i>
                                <span class="stat-title">Замовлення</span>
                            </div>
                            <span class="stat-period">Сьогодні</span>
                        </div>
                        <div class="stat-value"><?= $statistics['day']['orders'] ?></div>
                        <div class="stat-change <?= $statistics['day']['change']['orders'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['day']['change']['orders'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['day']['change']['orders']) ?>%
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-shopping-cart stat-icon orders-icon"></i>
                                <span class="stat-title">Замовлення</span>
                            </div>
                            <span class="stat-period">Тиждень</span>
                        </div>
                        <div class="stat-value"><?= $statistics['week']['orders'] ?></div>
                        <div class="stat-change <?= $statistics['week']['change']['orders'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['week']['change']['orders'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['week']['change']['orders']) ?>%
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-shopping-cart stat-icon orders-icon"></i>
                                <span class="stat-title">Замовлення</span>
                            </div>
                            <span class="stat-period">Місяць</span>
                        </div>
                        <div class="stat-value"><?= $statistics['month']['orders'] ?></div>
                        <div class="stat-change <?= $statistics['month']['change']['orders'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['month']['change']['orders'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['month']['change']['orders']) ?>%
                        </div>
                    </div>

                    <!-- Заробіток -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-money-bill-wave stat-icon earnings-icon"></i>
                                <span class="stat-title">Заробіток</span>
                            </div>
                            <span class="stat-period">Сьогодні</span>
                        </div>
                        <div class="stat-value"><?= number_format($statistics['day']['earnings'], 2) ?> ₴</div>
                        <div class="stat-change <?= $statistics['day']['change']['earnings'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['day']['change']['earnings'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['day']['change']['earnings']) ?>%
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-money-bill-wave stat-icon earnings-icon"></i>
                                <span class="stat-title">Заробіток</span>
                            </div>
                            <span class="stat-period">Тиждень</span>
                        </div>
                        <div class="stat-value"><?= number_format($statistics['week']['earnings'], 2) ?> ₴</div>
                        <div class="stat-change <?= $statistics['week']['change']['earnings'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['week']['change']['earnings'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['week']['change']['earnings']) ?>%
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-money-bill-wave stat-icon earnings-icon"></i>
                                <span class="stat-title">Заробіток</span>
                            </div>
                            <span class="stat-period">Місяць</span>
                        </div>
                        <div class="stat-value"><?= number_format($statistics['month']['earnings'], 2) ?> ₴</div>
                        <div class="stat-change <?= $statistics['month']['change']['earnings'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['month']['change']['earnings'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['month']['change']['earnings']) ?>%
                        </div>
                    </div>

                    <!-- Відстань -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-route stat-icon distance-icon"></i>
                                <span class="stat-title">Відстань</span>
                            </div>
                            <span class="stat-period">Сьогодні</span>
                        </div>
                        <div class="stat-value"><?= number_format($statistics['day']['distance'], 2) ?> км</div>
                        <div class="stat-change <?= $statistics['day']['change']['distance'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['day']['change']['distance'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['day']['change']['distance']) ?>%
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-route stat-icon distance-icon"></i>
                                <span class="stat-title">Відстань</span>
                            </div>
                            <span class="stat-period">Тиждень</span>
                        </div>
                        <div class="stat-value"><?= number_format($statistics['week']['distance'], 2) ?> км</div>
                        <div class="stat-change <?= $statistics['week']['change']['distance'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['week']['change']['distance'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['week']['change']['distance']) ?>%
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div>
                                <i class="fas fa-route stat-icon distance-icon"></i>
                                <span class="stat-title">Відстань</span>
                            </div>
                            <span class="stat-period">Місяць</span>
                        </div>
                        <div class="stat-value"><?= number_format($statistics['month']['distance'], 2) ?> км</div>
                        <div class="stat-change <?= $statistics['month']['change']['distance'] >= 0 ? 'positive' : 'negative' ?>">
                            <i class="fas fa-<?= $statistics['month']['change']['distance'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                            <?= abs($statistics['month']['change']['distance']) ?>%
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>
</body>

</html>